<?php
include('includes/header.php');
include('functions/userfunctions.php');


if (isset($_GET['search']) || isset($_GET['price'])) {
    $searchTerm = $_GET['search'];
    $price = $_GET['price'];
    
    $cleanSearchTerm = str_replace('%', '', $searchTerm);
    
    $query = "SELECT * FROM products WHERE name LIKE ?";
    $stmt = $con->prepare($query);
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bind_param("s", $searchTerm);

    if (!empty($price)) {
        $query .= " AND selling_price <= ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sd", $searchTerm, $price);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <div class="container mt-4">
        <h4>Kết quả tìm kiếm cho: <?= htmlspecialchars($cleanSearchTerm) ?></h4>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-3 text-center">';
                    echo '<a href="product-view.php?product=' . htmlspecialchars($product['slug']) . '">'; 
                    echo '<div class="card shadow">';
                    echo '<img src="uploads/' . htmlspecialchars($product['image']) . '" alt="Product Image" class="img-fluid product-image shadow-sm">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
                    echo '<p class="card-text">Giá: VND ' . number_format($product['selling_price']) . '</p>';
                    echo '</div></div></a>';
                    echo '</div>';
                }
            } else {
                echo '<p>Không tìm thấy sản phẩm nào.</p>';
            }
            ?>
        </div>
    </div>
    <?php

    $stmt->close();
} else {
    echo '<p>Vui lòng nhập thông tin tìm kiếm.</p>';
}

include('includes/footer.php');
?>
