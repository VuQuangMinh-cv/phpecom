<?php 
session_start();
include('config/dbcon.php');

if (!isset($_SESSION['auth_user'])) {
    $_SESSION['message'] = "Bạn cần đăng nhập trước khi truy cập trang này";
    header('Location: login.php');
    exit();
}

include('includes/header.php'); 

$user_id = $_SESSION['auth_user']['user_id'];
$stmt = $con->prepare("SELECT * FROM users WHERE id = ?"); //prepare
$stmt->bind_param("i", $user_id);
$stmt->execute();
$query_run = $stmt->get_result();

if ($query_run->num_rows > 0) {
    $user_data = $query_run->fetch_assoc();
}
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php 
                if (isset($_SESSION['message'])) {
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Thông báo:</strong> <?= htmlspecialchars($_SESSION['message']); ?>.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                    unset($_SESSION['message']);
                }
                ?>

                <div class="card">
                    <div class="card-header">
                        <h4>Chỉnh sửa thông tin cá nhân</h4>
                    </div>
                    <div class="card-body">
                        <form action="update_profile.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($user_data['name']); ?>" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" value="<?= htmlspecialchars($user_data['phone']); ?>" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($user_data['email']); ?>" class="form-control" required readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu mới (Để trống nếu không thay đổi)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <button type="submit" name="update_profile_btn" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
