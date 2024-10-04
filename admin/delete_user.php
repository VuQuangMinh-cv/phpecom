<?php
session_start();
include("../config/dbcon.php");

if (!isset($_SESSION['auth']) || $_SESSION['role_as'] != 1) {
    $_SESSION['message'] = "Bạn không có quyền truy cập trang này.";
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

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
