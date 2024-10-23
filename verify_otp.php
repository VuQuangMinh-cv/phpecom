<?php
session_start();

if (!isset($_SESSION['otp_attempts'])) {
    $_SESSION['otp_attempts'] = 0;
}

if (isset($_SESSION['lockout_time']) && (time() < $_SESSION['lockout_time'])) {
    $wait_time = ($_SESSION['lockout_time'] - time()) / 60;
    $_SESSION['message'] = "Bạn đã nhập sai quá nhiều lần. Vui lòng đợi " . ceil($wait_time) . " phút.";
    header("Location: lockout.php");
    exit(0);
}

if (isset($_POST['otp'])) {
    $entered_otp = trim($_POST['otp']);
    $generated_otp = isset($_SESSION['otp']) ? $_SESSION['otp'] : null;
    $otp_expiry = isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] : null;

    if (time() > $otp_expiry) {
        $_SESSION['message'] = "OTP đã hết hạn. Vui lòng yêu cầu một OTP mới.";
        header("Location: send_otp.php");
        exit(0);
    }

    if ($entered_otp === $generated_otp) {
        $_SESSION['otp_verified'] = true;
        unset($_SESSION['otp'], $_SESSION['otp_expiry']);
        $_SESSION['otp_attempts'] = 0; 
        $_SESSION['message'] = "Xác thực OTP thành công.";
        header("Location: checkout.php");
        exit(0);
    } else {
        $_SESSION['otp_attempts']++; 
        if ($_SESSION['otp_attempts'] >= 3) {
            $_SESSION['lockout_time'] = time() + 15 * 60; 
            $_SESSION['message'] = "Bạn đã nhập sai quá 3 lần. Vui lòng thử lại sau 15 phút.";
            header("Location: lockout.php");
            exit(0);
        } else {
            $_SESSION['message'] = "OTP không hợp lệ. Bạn đã thử sai " . $_SESSION['otp_attempts'] . " lần.";
            header("Location: verify_otp_form.php");
            exit(0);
        }
    }
} else {
    $_SESSION['message'] = "OTP chưa được nhập.";
    header("Location: verify_otp_form.php");
    exit(0);
}

?>
