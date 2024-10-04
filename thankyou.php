<?php
session_start();
include("config/dbcon.php");
include("includes/header.php");
include("authenticate.php");

$order_id = isset($_GET['order_id']) ? mysqli_real_escape_string($con, $_GET['order_id']) : "";

if($order_id == "") {
    $_SESSION['message'] = "Invalid Order ID";
    header("Location: index.php");
    exit();
}

$order_query = "SELECT * FROM orders WHERE tracking_no='$order_id' AND user_id='".$_SESSION['auth_user']['user_id']."'";
$order_run = mysqli_query($con, $order_query);
$order = mysqli_fetch_array($order_run);

if(!$order) {
    $_SESSION['message'] = "Order not found";
    header("Location: my-orders.php");
    exit();
}
?>

<div class="py-5">
    <div class="container">
        <div class="card">
            <div class="card-body text-center">
                <h2>Thank you for your order!</h2>
                <p>Your order has been placed successfully.</p>
                <h4>Order ID: <?= htmlspecialchars($order['tracking_no']) ?></h4>
                <p>We have sent a confirmation email to <strong><?= htmlspecialchars($order['email']) ?></strong>.</p>
                <a href="index.php" class="btn btn-primary mt-3">Go to Home</a>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php") ?>
