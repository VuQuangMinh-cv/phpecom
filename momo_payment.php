<?php
header('Content-type: text/html; charset=utf-8');

function execPostRequest($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

$orderInfo = "Thanh toán QR qua MoMo";
$amount = "22000"; // Số tiền thanh toán
$orderId = time() . "";
$redirectUrl = "http://yourdomain.com/thankyou.php"; // URL trả về sau khi thanh toán thành công
$ipnUrl = "https://webhook.site/your-webhook-url"; // Đảm bảo bạn thay thế bằng URL hợp lệ
$extraData = ""; // Giá trị mặc định cho extraData

$requestId = time() . "";
$requestType = "captureWallet";

// Tạo chuỗi hash để ký
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;

$signature = hash_hmac("sha256", $rawHash, $secretKey); // Đã sửa lại biến

$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl, // Đảm bảo ipnUrl có giá trị
    'lang' => 'vi',
    'extraData' => $extraData, // Đảm bảo extraData có giá trị
    'requestType' => $requestType,
    'signature' => $signature
);

$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);  // Giải mã phản hồi JSON

// Kiểm tra xem có trả về payUrl không
if (isset($jsonResult['payUrl'])) {
    header('Location: ' . $jsonResult['payUrl']); // Chuyển hướng tới trang thanh toán
    exit();
} else {
    // Nếu không có payUrl, hiển thị thông báo lỗi
    echo "Không thể lấy đường dẫn thanh toán. Lỗi: " . json_encode($jsonResult);
}
?>
