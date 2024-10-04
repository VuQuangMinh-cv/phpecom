<nav class="navbar navbar-expand-lg navbar-dark sticky-top bg-dark shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php">Ecom</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <form action="search.php" method="GET" class="d-flex mx-5">
            <input type="text" name="search" placeholder="Tìm kiếm" class="form-control form-control-sm me-2" required>
            <input type="number" name="price" placeholder="Giá (VND)" class="form-control form-control-sm me-2" min="0">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>
        </form>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="categories.php">Collections</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <?php
                if (isset($_SESSION['auth'])) {
                    if ($_SESSION['role_as'] == 1) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./admin/category.php">Dashboard</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['auth_user']['name']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="my-orders.php">My Orders</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Log In</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
