<?php
session_start();
include 'config.php';

if (empty($_SESSION['orderId'])) {
    echo "Không tìm thấy thông tin đơn hàng.";
    exit();
}

if ($_GET['result'] == "success") {
    echo "Thanh toán thành công. Cảm ơn bạn đã đặt hàng!";
} else {
    echo "Thanh toán thất bại. Vui lòng thử lại.";
}
?>
