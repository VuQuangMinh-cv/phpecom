<?php
session_start();
include('config/dbcon.php');

if (isset($_POST['update_profile_btn'])) {
    $user_id = $_SESSION['auth_user']['user_id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $new_email = !empty($_POST['new_email']) ? mysqli_real_escape_string($con, $_POST['new_email']) : null;
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Kiểm tra độ dài sdt
    if (strlen($phone) != 10) {
        $_SESSION['message'] = "Số điện thoại phải có 10 chữ số";
        header("Location: edit_profile.php");
        exit();
    }

    // Kiểm tra xem email đã tồn tại chưa
    $email_check_query = "SELECT * FROM users WHERE email='$new_email' AND id != '$user_id'";
    if ($new_email && mysqli_num_rows(mysqli_query($con, $email_check_query)) > 0) {
        $_SESSION['message'] = "Email đã tồn tại";
        header("Location: edit_profile.php");
        exit();
    }

    // Kiểm tra số điện thoại có tồn tại chưa
    $phone_check_query = "SELECT * FROM users WHERE phone='$phone' AND id != '$user_id'";
    if (mysqli_num_rows(mysqli_query($con, $phone_check_query)) > 0) {
        $_SESSION['message'] = "Số điện thoại đã tồn tại";
        header("Location: edit_profile.php");
        exit();
    }

    // Nếu có email mới, gửi OTP
    if ($new_email) {
        $_SESSION['new_email'] = $new_email; 
        $_SESSION['otp'] = rand(100000, 999999); 
        $otp = $_SESSION['otp'];

        $subject = "Mã xác thực OTP của bạn";
        $message = "Mã OTP của bạn là: $otp";
        mail($new_email, $subject, $message);

        $_SESSION['message'] = "Một mã OTP đã được gửi đến email mới của bạn.";
        header("Location: verify_otp.php");
        exit();
    }

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET name='$name', phone='$phone', password='$hashed_password' WHERE id='$user_id'";
    } else {
        $update_query = "UPDATE users SET name='$name', phone='$phone' WHERE id='$user_id'";
    }

    if (mysqli_query($con, $update_query)) {
        $_SESSION['message'] = "Cập nhật thông tin cá nhân thành công";
        $_SESSION['auth_user']['name'] = $name; 
        header("Location: edit_profile.php");
    } else {
        $_SESSION['message'] = "Có lỗi xảy ra trong quá trình cập nhật";
        header("Location: edit_profile.php");
    }
} else {
    header("Location: edit_profile.php");
}
