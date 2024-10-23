<?php

include("../config/dbcon.php"); 
include('includes/header.php');   
include('../middleware/adminMiddleware.php'); 

$sql = "
    SELECT 
        o.prod_id AS product_id, 
        p.name AS product_name, 
        SUM(o.qty) AS total_sold
    FROM 
        order_items o
    JOIN 
        products p ON o.prod_id = p.id
    GROUP BY 
        o.prod_id, p.name
";

$result = $con->query($sql);

if (!$result) {
    die("Lỗi truy vấn: " . $con->error);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Số Lượng Sản Phẩm Đã Bán</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        table th, table td {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include('includes/navbar.php'); ?> 

    <div class="container">
        <h2 class="mb-4">Số Lượng Sản Phẩm Đã Bán</h2>
        <div class="card">
            <div class="card-header">
                Tổng Số Lượng Sản Phẩm Đã Bán
            </div>
            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mã Sản Phẩm</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Tổng Số Lượng Đã Bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['product_id']) ?></td>
                                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                                    <td><?= number_format($row['total_sold'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Không có dữ liệu để hiển thị.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$con->close();
?>
