<?php
include("../config/dbcon.php");
include('includes/header.php');
include('../middleware/adminMiddleware.php');

// Tổng giá trị hôm nay
$sql_today = "SELECT SUM(total_price) AS total_today FROM orders WHERE DATE(created_at) = CURDATE() AND status = '1'";
$result_today = $con->query($sql_today);
$total_today = $result_today->fetch_assoc()['total_today'] ?? 0;

// Tổng giá trị hôm qua
$sql_yesterday = "SELECT SUM(total_price) AS total_yesterday FROM orders WHERE DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND status = '1'";
$result_yesterday = $con->query($sql_yesterday);
$total_yesterday = $result_yesterday->fetch_assoc()['total_yesterday'] ?? 0;

// Tổng giá trị tuần qua
$sql_week = "SELECT SUM(total_price) AS total_week FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK) AND status = '1'";
$result_week = $con->query($sql_week);
$total_week = $result_week->fetch_assoc()['total_week'] ?? 0;

// Tổng giá trị tháng qua
$sql_month = "SELECT SUM(total_price) AS total_month FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH) AND status = '1'";
$result_month = $con->query($sql_month);
$total_month = $result_month->fetch_assoc()['total_month'] ?? 0;

// Tổng giá trị năm qua
$sql_year = "SELECT SUM(total_price) AS total_year FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR) AND status = '1'";
$result_year = $con->query($sql_year);
$total_year = $result_year->fetch_assoc()['total_year'] ?? 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thống Kê Doanh Số</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Sử dụng Bootstrap cho giao diện đẹp hơn -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Thống Kê Doanh Số</h2>
        <div class="row">
            <!-- Thống Kê Hôm Nay -->
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Hôm Nay</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= number_format($total_today, 0, ',', '.') ?> VND</h5>
                        <p class="card-text">Tổng giá trị đơn hàng trong hôm nay.</p>
                    </div>
                </div>
            </div>
            <!-- Thống Kê Hôm Qua -->
            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-header">Hôm Qua</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= number_format($total_yesterday, 0, ',', '.') ?> VND</h5>
                        <p class="card-text">Tổng giá trị đơn hàng trong hôm qua.</p>
                    </div>
                </div>
            </div>
            <!-- Thống Kê Tuần Qua -->
             <div class="row">

            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Tuần Qua</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= number_format($total_week, 0, ',', '.') ?> VND</h5>
                        <p class="card-text">Tổng giá trị đơn hàng trong tuần qua.</p>
                    </div>
                </div>
            </div>
            <!-- Thống Kê Tháng Qua -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Tháng Qua</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= number_format($total_month, 0, ',', '.') ?> VND</h5>
                        <p class="card-text">Tổng giá trị đơn hàng trong tháng qua.</p>
                    </div>
                </div>
            </div>
            <!-- Thống Kê Năm Qua -->
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Năm Qua</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= number_format($total_year, 0, ',', '.') ?> VND</h5>
                        <p class="card-text">Tổng giá trị đơn hàng trong năm qua.</p>
                    </div>
                </div>
            </div>
            </div>

        </div>
    </div>
</body>
</html>
<?php
// Đóng kết nối
$con->close();
?>
