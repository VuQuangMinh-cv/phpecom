<?php
include('functions/userfunctions.php');
include("includes/header.php");

if(isset($_GET['product'])) {
    $product_slug = $_GET['product'];
    $product_data = getSlugActive("products", $product_slug);
    $product = mysqli_fetch_array($product_data);

    if($product) {
        ?>
        <div class="py-3 bg-primary">
            <div class="container">
                <h6 class="text-white">
                    <a class="text-white" href="categories.php">Home / </a>
                    <a class="text-white" href="categories.php">Collections / </a>
                    <?= htmlspecialchars($product['name']); ?>
                </h6>
            </div>
        </div>

        <div class="bg-light py-4">
            <div class="container product_data mt-3">
                <div class="row">
                    <div class="col-md-3">
                        <div class="shadow">
                            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="w-100">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h4 class="fw-bold"><?= htmlspecialchars($product['name']); ?>
                            <span class="float-end text-danger"><?= $product['trending'] ? "Trending" : ""; ?></span>
                        </h4>
                        <hr>
                        <p><?= htmlspecialchars($product['small_description']); ?></p>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>VND <span class="text-success fw-bold"><?= number_format($product['selling_price'], 0, ',', '.'); ?></span></h4>
                            </div>
                            <div class="col-md-6">
                                <h5>VND <s class="text-danger"><?= number_format($product['original_price'], 0, ',', '.'); ?></s></h5>
                            </div>
                        </div>

                        <!-- Thêm số lượng còn lại -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p>Số lượng còn lại: 
                                    <?php 
                                    if (isset($product['qty'])) {
                                        echo '<span class="text-info fw-bold">' . htmlspecialchars($product['qty']) . '</span>';
                                    } else {
                                        echo '<span class="text-danger">Liên hệ</span>';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3" style="width: 130px">
                                    <button class="input-group-text decrement-btn">-</button>
                                    <input type="text" class="form-control text-center input-qty bg-white" value="1" disabled>
                                    <button class="input-group-text increment-btn">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button class="btn btn-primary px-4 addToCartBtn" value="<?= htmlspecialchars($product['id']); ?>"><i class="fa fa-shopping-cart me-2"></i>Add to Cart</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger px-4"><i class="fa fa-heart me-2"></i>Add to Wishlist</button>
                            </div>
                        </div>

                        <hr>
                        <h6>Product Description:</h6>
                        <p><?= htmlspecialchars($product['description']); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo 'Product went wrong';
    }
} else {
    echo 'Something went wrong';
}

include("includes/footer.php");
include("includes/about.php");
?>
