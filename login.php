<?php 
session_start();

if (isset($_SESSION["auth"])) {
    $_SESSION["message"] = "Bạn đã đăng nhập rồi.";
    header('Location: index.php');
    exit();
}

include("includes/header.php");
include("./functions/cookie_handler.php");
?>

<div class="py-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php 
            if (isset($_SESSION['message'])) {
            ?>    
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Heyy!</strong> <?= htmlspecialchars($_SESSION['message']); ?>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php 
                unset($_SESSION['message']);
            }
            ?>

            <div class="card">
                <div class="card-header">
                    <h1>Đăng Nhập</h1>
                </div>
                <div class="card-body">
                    <form action="functions/authcode.php" method="POST">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Địa chỉ email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" id="exampleInputPassword1" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me">
                            <label class="form-check-label" for="rememberMe">Nhớ tôi</label>
                        </div>
                        <button type="submit" name="login_btn" class="btn btn-primary">Đăng Nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php
 include("includes/footer.php");
 include("includes/about.php");
?>
