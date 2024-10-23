<?php 
session_start();

if (isset($_SESSION["auth"])) {
    $_SESSION["message"] = "You are already logged in";
    header('Location: index.php');
    exit();
}

include("includes/header.php");
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php 
                if (isset($_SESSION['message'])) {
                ?>    
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Thông báo:</strong> <?= $_SESSION['message']; ?>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php 
                    unset($_SESSION['message']);
                }
                ?>

                <div class="card">
                    <div class="card-header">
                        <h1>Đăng ký</h1>
                    </div>
                    <div class="card-body">
                        <form action="functions/authcode.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên của bạn" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="number" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Địa chỉ Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" id="exampleInputPassword1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" name="cpassword" placeholder="Nhập lại mật khẩu" class="form-control" required>
                            </div>

                            <button type="submit" name="register_btn" class="btn btn-primary">Đăng ký</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php") ?>
