<?php
ob_start();
include("../config/dbcon.php");
include('includes/header.php'); 

if (!isset($_SESSION['auth']) || $_SESSION['role_as'] != 1) {
    $_SESSION['message'] = "Bạn không có quyền truy cập trang này.";
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $query = "SELECT * FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $user = mysqli_fetch_assoc($query_run);
    } else {
        $_SESSION['message'] = "Người dùng không tồn tại";
        header('Location: users.php');
        exit();
    }
}

if (isset($_POST['update_user_btn'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $role_as = $_POST['role_as'];

    $update_query = "UPDATE users SET name='$name', email='$email', phone='$phone', role_as='$role_as' WHERE id='$user_id'";
    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        $_SESSION['message'] = "Cập nhật thông tin người dùng thành công";
        header('Location: users.php');
        exit();
    } else {
        $_SESSION['message'] = "Cập nhật thất bại";
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h4>Chỉnh sửa người dùng</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success">
                            <strong><?php echo $_SESSION['message']; ?></strong>
                        </div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label>Tên:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Điện thoại:</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Vai trò:</label>
                            <select name="role_as" class="form-control">
                                <option value="1" <?php if ($user['role_as'] == 1) echo 'selected'; ?>>Admin</option>
                                <option value="0" <?php if ($user['role_as'] == 0) echo 'selected'; ?>>User</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" name="update_user_btn" class="btn btn-primary">Cập nhật</button>
                    </form>

                    <a href="users.php" class="btn btn-secondary mt-3">Quay lại danh sách</a>
                    <a href="category.php" class="btn btn-secondary mt-3">Quay lại dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); 
ob_end_flush();
?>
