<?php
include('functions/userfunctions.php');
include("includes/header.php");
include('config/dbcon.php');


if (isset($_GET['category'])) {
    // Sử dụng mysqli_real_escape_string để bảo vệ chống SQL Injection
    $category_slug = mysqli_real_escape_string($con, $_GET['category']);
    $category_data = getSlugActive("categories", $category_slug);
    $category = mysqli_fetch_assoc($category_data);

    if ($category) {
        $cid = $category['id'];
        ?>
        <div class="py-3 bg-primary">
            <div class="container">
                <h6 class="text-white">
                    <a class="text-white" href="categories.php">Home / </a>
                    <a class="text-white" href="categories.php">Collections / </a>
                    <?= htmlspecialchars($category['name']); ?>
                </h6>
            </div>
        </div>

        <div class="py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <h2><?= htmlspecialchars($category['name']); ?></h2>
                        <hr>
                        <div class="row">

                            <?php 
                                $products = getProdByCategory($cid);

                                if ($products && mysqli_num_rows($products) > 0) {
                                    while ($item = mysqli_fetch_assoc($products)) {
                                        ?>
                                        <div class="col-md-3 mb-2">
                                            <a href="product-view.php?product=<?= htmlspecialchars($item['slug']); ?>">
                                                <div class="card shadow">
                                                    <div class="card-body">
                                                        <img src="uploads/<?= htmlspecialchars($item['image']); ?>" alt="Product Image" class="w-100">
                                                        <h4 class="text-center"><?= htmlspecialchars($item['name']); ?></h4>
                                                        <p style="color: green; text-decoration: none;" class="text-center fw-bold">
                                                            Giá: VND <?= number_format($item['selling_price'], 0, ',', '.'); ?>
                                                        </p>
                                                        <p class="text-center">
                                                            Số lượng còn lại: 
                                                            <?php 
                                                                if (isset($item['qty'])) {
                                                                    echo '<span class="text-info">' . htmlspecialchars($item['qty']) . '</span>';
                                                                } else {
                                                                    echo '<span class="text-danger">Liên hệ</span>';
                                                                }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo '<div class="col-12"><p class="text-center">Không có sản phẩm nào trong danh mục này.</p></div>';
                                }
                            ?>  
                        </div>
                    </div>
                </div>
                <br><br><br><br><br><br><br>                <br>


            </div>
        </div>

        <?php 
    } else {
        echo '<div class="container"><p class="text-danger">Danh mục không tồn tại hoặc đã bị xóa.</p></div>';
    }

} else {
    echo '<div class="container"><p class="text-danger">Không tìm thấy danh mục.</p></div>';
}

include("includes/footer.php");
include("includes/about.php");?>
