<?php
include("../config/dbcon.php");
include('includes/header.php');

if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Bạn cần đăng nhập để truy cập trang này.";
    header('Location: ../login.php');
    exit();
}

if ($_SESSION['role_as'] != 1) {
    $_SESSION['message'] = "Bạn không có quyền truy cập trang này.";
    header('Location: ../index.php');
    exit();
}

$query = "SELECT id, name, email, phone, role_as FROM users";
$query_run = mysqli_query($con, $query);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Danh sách người dùng</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success">
                            <strong><?php echo $_SESSION['message']; ?></strong>
                        </div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($user = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $user['id']; ?></td>
                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                        <td>
                                            <?php
                                            if ($user['role_as'] == 1) {
                                                echo 'Admin';
                                            } else {
                                                echo 'User';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="6">Không có dữ liệu người dùng nào.</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <a href="../logout.php" class="btn btn-secondary">Đăng xuất</a>
                    <a href="category.php" class="btn btn-secondary">Quay lại dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
