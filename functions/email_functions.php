<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
function sendOrderConfirmationEmail($to, $name, $tracking_no, $order_details, $totalPrice) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'vqmnbtami@gmail.com'; 
        $mail->Password = 'wgph eins ljcj cnsm'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('E.miu-shop@gmail.com', 'E.Miu-Shop'); 
        $mail->addAddress($to, $name); 

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Đơn hàng của bạn đã được đặt thành công';
        $mail->Body    = generateEmailBody($tracking_no, $order_details, $totalPrice); // Gọi hàm tạo nội dung email

        $mail->send();
    } catch (Exception $e) {
        error_log("Email không thể gửi. Lỗi: {$mail->ErrorInfo}");
    }
}

function generateEmailBody($tracking_no, $order_details, $totalPrice) {
    $body = "<h1>Đơn hàng của bạn đã được đặt thành công</h1>";
    $body .= "<p>Mã theo dõi đơn hàng: $tracking_no</p>";
    $body .= "<table border='1'>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>";
    
    foreach($order_details as $item) {
        $formatted_price = number_format($item['selling_price'], 0, ',', '.');
        $body .= "<tr>
                    <td>{$item['name']}</td>
                    <td>{$item['prod_qty']}</td>
                    <td>{$formatted_price} VND</td>
                  </tr>";
    }

    $formatted_totalPrice = number_format($totalPrice, 0, ',', '.');
    $body .= "</table>";
    $body .= "<p>Tổng giá: $formatted_totalPrice VND</p>";
    
    return $body;
}


?>
