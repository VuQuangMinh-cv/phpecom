<?php
session_start();
require 'vendor/autoload.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generateOTP($length = 6) {
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= rand(0, 9);
    }
    return $otp;
}

// Xóa thông tin OTP
unset($_SESSION['otp']);
unset($_SESSION['otp_verified']);

$otp = generateOTP();
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 300; // 5p

if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['auth_user']['email'];

function sendOtpEmail($to, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'vqmnbtami@gmail.com'; 
        $mail->Password = 'wgph eins ljcj cnsm';   
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('E.miu-shop@gmail.com', 'E.Miu-Shop');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: $otp. This code is valid for 5 minutes.";

        // Gửi email
        $mail->send();
        echo 'OTP has been sent successfully.';
    } catch (Exception $e) {
        echo 'Error sending OTP: ', $mail->ErrorInfo;
    }
}

sendOtpEmail($user_email, $otp);

header("Location: verify_otp_form.php");
exit();
?>
