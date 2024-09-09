<?php
session_start();
include("../config/dbcon.php");

// Kiểm tra xem người dùng có đăng nhập không
if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Bạn cần đăng nhập để truy cập trang này.";
    header('Location: ../login.php');
    exit();
}

// Nếu người dùng có vai trò admin (giả sử '1' là admin)
if ($_SESSION['role_as'] != 1) {
    $_SESSION['message'] = "Bạn không có quyền truy cập trang này.";
    header('Location: ../index.php');
    exit();
}

// Truy vấn để lấy dữ liệu tất cả người dùng từ cơ sở dữ liệu
$query = "SELECT id, name, email, phone, role_as FROM users";
$query_run = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng</title>
</head>
<body>
    <h1>Danh sách người dùng</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div>
            <strong><?php echo $_SESSION['message']; ?></strong>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <table border="1">
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Email</th>
        <th>Điện thoại</th>
        <th>Vai trò</th>
        <th>Hành động</th> <!-- Cột mới cho nút Edit và Xóa -->
    </tr>

    <?php
    if (mysqli_num_rows($query_run) > 0) {
        // Hiển thị dữ liệu người dùng
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
                    <!-- Nút Edit và Xóa -->
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">Xóa</a>
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
</table>

    <a href="../logout.php">Đăng xuất</a> <br>
    <a href="category.php">Quay lại dashboard</a> <br>

</body>
</html>
