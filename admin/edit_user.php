<?php
session_start();
include("../config/dbcon.php");

// Kiểm tra xem admin có đăng nhập không
if (!isset($_SESSION['auth']) || $_SESSION['role_as'] != 1) {
    $_SESSION['message'] = "Bạn không có quyền truy cập trang này.";
    header('Location: ../index.php');
    exit();
}

// Lấy ID người dùng từ URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Truy vấn để lấy thông tin người dùng
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

// Cập nhật thông tin người dùng
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa người dùng</title>
</head>
<body>
    <h1>Chỉnh sửa người dùng</h1>

    <form method="POST">
        <label>Tên:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label>Điện thoại:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required><br>

        <label>Vai trò:</label>
        <select name="role_as">
            <option value="1" <?php if ($user['role_as'] == 1) echo 'selected'; ?>>Admin</option>
            <option value="0" <?php if ($user['role_as'] == 0) echo 'selected'; ?>>User</option>
        </select><br>

        <button type="submit" name="update_user_btn">Cập nhật</button>
    </form>

    <a href="users.php">Quay lại danh sách</a> <br>
    <a href="category.php">Quay lại dashboard</a>

</body>
</html>
