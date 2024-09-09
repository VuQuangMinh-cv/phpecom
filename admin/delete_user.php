<?php
session_start();
include("../config/dbcon.php");

// Kiểm tra xem admin có đăng nhập không
if (!isset($_SESSION['auth']) || $_SESSION['role_as'] != 1) {
    $_SESSION['message'] = "Bạn không có quyền truy cập trang này.";
    header('Location: ../index.php');
    exit();
}

// Lấy ID người dùng từ URL và xóa
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Truy vấn để xóa người dùng
    $delete_query = "DELETE FROM users WHERE id='$user_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {
        $_SESSION['message'] = "Xóa người dùng thành công";
    } else {
        $_SESSION['message'] = "Xóa thất bại";
    }
    header('Location: users.php');
    exit();
}
?>
