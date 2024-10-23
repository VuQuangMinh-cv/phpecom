<?php
// Kiểm tra xem có dữ liệu gửi từ MoMo không
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ POST
    $data = json_decode(file_get_contents('php://input'), true); // Giải mã JSON từ body

    // Kiểm tra xem dữ liệu có được trả về không
    if ($data !== null) {
        // Kiểm tra từng giá trị cần thiết
        if (isset($data['orderId'])) {
            $orderId = $data['orderId'];
            // Xử lý dữ liệu của bạn tại đây
        } else {
            echo "orderId không tồn tại trong dữ liệu.";
        }

        // Kiểm tra thêm các giá trị khác tùy theo nhu cầu của bạn
        if (isset($data['amount'])) {
            $amount = $data['amount'];
            // Tiếp tục xử lý...
        } else {
            echo "amount không tồn tại trong dữ liệu.";
        }
    } else {
        echo "Không nhận được dữ liệu từ MoMo.";
    }
} else {
    echo "Phương thức không hợp lệ.";
}
?>
