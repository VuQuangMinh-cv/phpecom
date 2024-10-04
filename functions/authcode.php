<?php

session_start();
include("../config/dbcon.php");
include("myfunctions.php");
include('cookie_handler.php'); 

if (isset($_POST['register_btn'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    if(strlen($phone) != 10) {
        $_SESSION['message'] = "Số điện thoại phải có 10 chữ số";
        header('Location: ../register.php');
        exit();
    }

    $check_phone_query = "SELECT phone FROM users WHERE phone='$phone'";
    $check_phone_query_run = mysqli_query($con, $check_phone_query);
    
    if(mysqli_num_rows($check_phone_query_run) > 0) {
        $_SESSION['message'] = "Số điện thoại đã tồn tại";
        header('Location: ../register.php');
        exit();
    }

    $check_email_query = "SELECT email FROM users WHERE email='$email'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['message'] = "Email đã tồn tại";
        header('Location: ../register.php');
    } else {
        if ($password == $cpassword) {
            // insert user data
            $insert_query = "INSERT INTO users(name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
            $insert_query_run = mysqli_query($con, $insert_query);

            if ($insert_query_run) {
                $_SESSION['message'] = "Đăng ký thành công";
                header('Location: ../login.php');
            } else {
                $_SESSION['message'] = "Đã xảy ra lỗi";
                header('Location: ../register.php');
            }
        } else {
            $_SESSION['message'] = "Mật khẩu không khớp";
            header('Location: ../register.php');
        }
    }
} else if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $login_query_run = mysqli_query($con, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        // Xác thực người dùng
        $_SESSION['auth'] = true;

        $userdata = mysqli_fetch_array($login_query_run);
        $user_id = $userdata['id'];
        $username = $userdata['name'];
        $useremail = $userdata['email'];
        $role_as = $userdata['role_as'];

        $_SESSION['auth_user'] = [
            'user_id' => $user_id,
            'name' => $username,
            'email' => $useremail
        ];

        $_SESSION['role_as'] = $role_as;

        if (isset($_POST['remember_me'])) {
            setLoginCookies($userdata); 
        }

        if ($role_as == 1) {
            redirect("../admin/index.php", "Chào mừng đến bảng điều khiển");
        } else {
            redirect("../index.php", "Đăng nhập thành công");
        }
    } else {
        redirect("../login.php", "Thông tin đăng nhập không hợp lệ");
    }
}
?>
