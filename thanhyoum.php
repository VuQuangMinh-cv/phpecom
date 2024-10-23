<?php
session_start();
include("config/dbcon.php");
include("includes/header.php");
include("authenticate.php");

$order_id = isset($_GET['orderId']) ? mysqli_real_escape_string($con, $_GET['orderId']) : "";
$result_code = isset($_GET['resultCode']) ? mysqli_real_escape_string($con, $_GET['resultCode']) : "";

if($order_id == "") {
    $_SESSION['message'] = "Mã đơn hàng không hợp lệ";
    header("Location: index.php");
    exit();
}

$order_query = "SELECT * FROM orders WHERE tracking_no='$order_id' AND user_id='".$_SESSION['auth_user']['user_id']."'";
$order_run = mysqli_query($con, $order_query);
$order = mysqli_fetch_array($order_run);

if(!$order) {
    $_SESSION['message'] = "Đơn hàng không tìm thấy";
    header("Location: my-orders.php");
    exit();
}

if($result_code == '0') {
    ?>

    <div class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body text-center">
                    <h2>Cám ơn bạn đã đặt hàng!</h2>
                    <p>Đơn hàng của bạn đã được thanh toán thành công.</p>
                    <h4>Mã đơn hàng: <?= htmlspecialchars($order['tracking_no']) ?></h4>
                    <p>Chúng tôi đã gửi email xác nhận tới <strong><?= htmlspecialchars($order['email']) ?></strong>.</p>
                    <a href="index.php" class="btn btn-primary mt-3">Về trang chủ</a>
                </div>
            </div>
        </div>
    </div>

    <?php
} else {
    ?>

    <div class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body text-center">
                    <h2>Thanh toán thất bại!</h2>
                    <p>Giao dịch của bạn không thành công. Vui lòng thử lại.</p>
                    <a href="index.php" class="btn btn-danger mt-3">Về trang chủ</a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>

<?php include("includes/footer.php") ?>
