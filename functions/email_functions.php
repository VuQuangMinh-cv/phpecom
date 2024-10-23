<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 *
 * @param string $to 
 * @param string $name 
 * @param string $phone 
 * @param string $address 
 * @param string $tracking_no 
 * @param array $order_details 
 * @param float $totalPrice 
 */
function sendOrderConfirmationEmail($to, $name, $phone, $address, $tracking_no, $order_details, $totalPrice, $order_time) {
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
        $mail->Body    = generateEmailBody($name, $phone, $address, $tracking_no, $order_details, $totalPrice, $order_time); // Gọi hàm tạo nội dung email

        $mail->send();
    } catch (Exception $e) {
        error_log("Email không thể gửi. Lỗi: {$mail->ErrorInfo}");
    }
}

/**
 *
 * @param string $name 
 * @param string $phone 
 * @param string $address 
 * @param string $tracking_no 
 * @param array $order_details 
 * @param float $totalPrice 
 * @return string 
 */
function generateEmailBody($name, $phone, $address, $tracking_no, $order_details, $totalPrice, $order_time) {
    $body = "<h1>Đơn hàng của bạn đã được đặt thành công</h1>";
    $body .= "<p><strong>Tên khách hàng:</strong> $name</p>";
    $body .= "<p><strong>Số điện thoại:</strong> $phone</p>";
    $body .= "<p><strong>Địa chỉ nhận hàng:</strong> $address</p>";
    $body .= "<p><strong>Mã theo dõi đơn hàng:</strong> $tracking_no</p>";
    
    // Thêm thời gian đặt hàng vào nội dung email
    $body .= "<p><strong>Thời gian đặt hàng:</strong> $order_time</p>";
    
    $body .= "<table border='1' cellpadding='10' cellspacing='0'>
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
    $body .= "<p><strong>Tổng giá:</strong> $formatted_totalPrice VND</p>";
    
    $body .= "<p>Đơn hàng sẽ được giao cho bạn sớm!</p>";
    $body .= "<p>Cảm ơn bạn đã mua sắm tại <strong>E.Miu_Shop</strong>!</p>";
    
    return $body;

}

?>
