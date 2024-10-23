<?php
session_start();

if (!isset($_SESSION['auth_user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['otp_expiry']) && time() > $_SESSION['otp_expiry']) {
    echo 'Your OTP has expired. Please request a new one.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác minh OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Xác minh OTP</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-warning">
                <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        
        <form action="verify_otp.php" method="POST">
            <div class="mb-3">
                <label for="otp" class="form-label">Nhập mã OTP:</label>
                <input type="text" id="otp" name="otp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Xác minh</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
