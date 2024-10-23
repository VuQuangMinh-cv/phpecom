<?php

session_start();
include("../config/dbcon.php");
include("myfunctions.php");
include('cookie_handler.php'); 

// Đăng ký người dùng mới
if (isset($_POST['register_btn'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    // Kiểm tra độ dài số điện thoại
    if (strlen($phone) != 10) {
        $_SESSION['message'] = "Số điện thoại phải có 10 chữ số";
        header('Location: ../register.php');
        exit();
    }

    // Kiểm tra xem số điện thoại đã tồn tại chưa
    $check_phone_query = "SELECT phone FROM users WHERE phone='$phone'";
    $check_phone_query_run = mysqli_query($con, $check_phone_query);
    
    if (mysqli_num_rows($check_phone_query_run) > 0) {
        $_SESSION['message'] = "Số điện thoại đã tồn tại";
        header('Location: ../register.php');
        exit();
    }

    // Kiểm tra xem email đã tồn tại chưa
    $check_email_query = "SELECT email FROM users WHERE email='$email'";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['message'] = "Email đã tồn tại";
        header('Location: ../register.php');
        exit();
    } 

    // Kiểm tra mật khẩu và xác nhận mật khẩu
    if ($password === $cpassword) {
        // Băm mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO users(name, email, phone, password) VALUES ('$name', '$email', '$phone', '$hashed_password')";
        $insert_query_run = mysqli_query($con, $insert_query);
    
        if ($insert_query_run) {
            $_SESSION['message'] = "Đăng ký thành công";
            header('Location: ../login.php');
            exit();
        } else {
            $_SESSION['message'] = "Đã xảy ra lỗi khi đăng ký";
            header('Location: ../register.php');
            exit();
        }
    } else {
        $_SESSION['message'] = "Mật khẩu không khớp";
        header('Location: ../register.php');
        exit();
    }

} else if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "SELECT * FROM users WHERE email='$email'";
    $login_query_run = mysqli_query($con, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        $userdata = mysqli_fetch_array($login_query_run);

        if (password_verify($password, $userdata['password'])) {
            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'user_id' => $userdata['id'],
                'name' => $userdata['name'],
                'email' => $userdata['email']
            ];

            $_SESSION['role_as'] = $userdata['role_as'];

            if (isset($_POST['remember_me'])) {
                setLoginCookies($userdata); 
            }

            if ($_SESSION['role_as'] == 1) {
                redirect("../admin/index.php", "Chào mừng đến bảng điều khiển");
            } else {
                redirect("../index.php", "Đăng nhập thành công");
            }
        } else {
            redirect("../login.php", "Thông tin đăng nhập không hợp lệ");
        }
    } else {
        redirect("../login.php", "Thông tin đăng nhập không hợp lệ");
    }
}

?>
