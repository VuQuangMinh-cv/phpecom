<?php
function encrypt($plaintext, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($plaintext, 'aes-256-cbc', $key, 0, $iv);
    
    // Kết hợp IV và dữ liệu đã mã hóa
    return base64_encode($iv . $encrypted);
}


function decrypt($encryptedData, $key) {
    $data = base64_decode($encryptedData);
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    
    // Đảm bảo rằng chuỗi dữ liệu đủ dài để chứa IV và dữ liệu mã hóa
    if (strlen($data) < $iv_length) {
        throw new Exception('Invalid data for decryption.');
    }

    $iv = substr($data, 0, $iv_length); // Lấy IV từ dữ liệu mã hóa
    $encrypted = substr($data, $iv_length); // Lấy dữ liệu đã mã hóa

    // Giải mã dữ liệu
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}
?>
