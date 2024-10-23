<?php

session_start();
include("../config/dbcon.php");
include('email_functions.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_SESSION['auth'])) {
    if(isset($_POST['placeOrderBtn']) || isset($_POST['payment_mode'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $pincode = mysqli_real_escape_string($con, $_POST['pincode']);
        $address = mysqli_real_escape_string($con, $_POST['address']);
        $payment_mode = mysqli_real_escape_string($con, $_POST['payment_mode']);
        $payment_id = isset($_POST['payment_id']) ? mysqli_real_escape_string($con, $_POST['payment_id']) : "";

        if($name == "" || $email == "" || $phone == "" || $pincode == "" || $address == "") {
            $_SESSION['message'] = "Tất cả các trường đều bắt buộc";
            header("Location: ../checkout.php");
            exit(0);
        }

        $userId = $_SESSION['auth_user']['user_id'];

        $query = "SELECT c.id as cid, c.prod_id, c.prod_qty, p.id as pid, p.name, p.image, p.selling_price, p.qty as product_qty 
                  FROM carts c, products p 
                  WHERE c.prod_id=p.id AND c.user_id='$userId' ORDER BY c.id DESC ";
        $query_run = mysqli_query($con, $query);

        $totalPrice = 0;
        $order_details = []; 

        foreach($query_run as $citem) {
            $totalPrice += $citem['selling_price'] * $citem['prod_qty']; 
            $order_details[] = [
                'name' => $citem['name'],
                'prod_qty' => $citem['prod_qty'],
                'selling_price' => $citem['selling_price']
            ];
        }

        $tracking_no = "NO1".rand(1111,9999).substr($phone,2);

        if($payment_mode == 'PayPal') {
            if(empty($payment_id)) {
                $_SESSION['message'] = "Payment ID is missing for PayPal";
                header("Location: ../checkout.php");
                exit(0);
            }

            function get_paypal_order_details($order_id) {
                $clientId = "AdmjjPCIh1OAjkAPx0PmG5sBghIDkbSpbmXkCnDXn8nQl3rkoNscVzC6LTNc_7vudWPev_zQCT8I2qEx"; 
                $secret = "EK67rWsVYuFsDVQbcDnBtpHB5bJJ4L_tSrUC2JYby4HvMkq-MlnS_qjxfEYfoLKOZMfYeJTaEVTJuYj4";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/oauth2/token"); 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

                $response = curl_exec($ch);
                if(empty($response)) {
                    return false;
                }

                $json = json_decode($response);
                $accessToken = $json->access_token;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v2/checkout/orders/" . $order_id);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $accessToken
                ]);

                $response = curl_exec($ch);
                if(empty($response)) {
                    return false;
                }

                return json_decode($response, true);
            }

            $paypal_order = get_paypal_order_details($payment_id);

            if(!$paypal_order) {
                $_SESSION['message'] = "Cannot fetch PayPal order details";
                header("Location: ../checkout.php");
                exit(0);
            }

            if($paypal_order['status'] != 'COMPLETED') {
                $_SESSION['message'] = "PayPal payment is not completed";
                header("Location: ../checkout.php");
                exit(0);
            }

            $paypal_total = 0;
            foreach($paypal_order['purchase_units'] as $unit) {
                $paypal_total += floatval($unit['amount']['value']);
            }

            $exchangeRate = 23000; 
            $paypal_total_vnd = $paypal_total * $exchangeRate;

            if(abs($paypal_total_vnd - $totalPrice) > 1000) { 
                $_SESSION['message'] = "Payment amount does not match the order total";
                header("Location: ../checkout.php");
                exit(0);
            }
        }

        $insert_query = "INSERT INTO orders (tracking_no, user_id, name, email, phone, address, pincode, 
                          total_price, payment_mode, payment_id) 
                          VALUES ('$tracking_no', '$userId', '$name', '$email', '$phone', '$address', '$pincode', '$totalPrice', '$payment_mode', '$payment_id')";
        
        $insert_query_run = mysqli_query($con, $insert_query);
        if (!$insert_query_run) {
            die("Query failed: " . mysqli_error($con));
        }

        $order_id = mysqli_insert_id($con); 

        foreach($query_run as $citem) {
            $prod_id = $citem['prod_id'];
            $prod_qty = $citem['prod_qty'];
            $price = $citem['selling_price'];

            $insert_items_query = "INSERT INTO order_items (order_id, prod_id, qty, price) 
                                   VALUES ('$order_id', '$prod_id', '$prod_qty', '$price')";
            $insert_items_run = mysqli_query($con, $insert_items_query);

            if ($insert_items_run) {
                $current_qty = $citem['product_qty'];
                $new_qty = $current_qty - $prod_qty;

                //Update products after buy
                $updateQty_query = "UPDATE products SET qty='$new_qty' WHERE id='$prod_id'";
                $updateQty_query_run = mysqli_query($con, $updateQty_query);

                if (!$updateQty_query_run) {
                    die("Failed to update product quantity: " . mysqli_error($con));
                }
            } else {
                die("Failed to insert order items: " . mysqli_error($con));
            }
        }

        // Cập nhật gọi hàm gửi email với các tham số mới
        sendOrderConfirmationEmail($email, $name, $phone, $address, $tracking_no, $order_details, $totalPrice, $order_time);

        $deleteCartQuery = "DELETE FROM carts WHERE user_id='$userId'";
        $deleteCartQuery_run = mysqli_query($con, $deleteCartQuery);
        if (!$deleteCartQuery_run) {
            die("Delete cart query failed: " . mysqli_error($con));
        }

        if($payment_mode == 'COD') {
            $_SESSION["message"] = "Đơn hàng đã được đặt thành công qua COD";
            header("Location: ../thankyou.php?order_id=$tracking_no");
            die();
        } else if($payment_mode == 'PayPal') {
            header("Location: ../thankyou.php?order_id=$tracking_no");
            die();
        } else {
            $_SESSION["message"] = "Unknown payment mode";
            header("Location: ../checkout.php");
            die();
        }
    }
} else {
    $_SESSION['message'] = "Bạn cần đăng nhập để đặt hàng.";
    header("Location: ../login.php");
    exit(0);
}

?>
