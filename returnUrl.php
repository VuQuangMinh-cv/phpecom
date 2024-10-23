<?php
// Lấy dữ liệu từ MoMo gửi về qua GET hoặc POST (tùy cấu hình)
$orderId = $_GET['orderId']; // Mã đơn hàng
$resultCode = $_GET['resultCode']; // Kết quả giao dịch (0 là thành công)

if ($resultCode == 0) {
    echo "Thanh toán thành công. Mã đơn hàng: " . $orderId;
    // Cập nhật trạng thái đơn hàng trong database
} else {
    echo "Thanh toán thất bại. Mã đơn hàng: " . $orderId;
    // Xử lý logic khi thanh toán thất bại
}
?>
