<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$clientId = "AdmjjPCIh1OAjkAPx0PmG5sBghIDkbSpbmXkCnDXn8nQl3rkoNscVzC6LTNc_7vudWPev_zQCT8I2qEx";
$secret = "EK67rWsVYuFsDVQbcDnBtpHB5bJJ4L_tSrUC2JYby4HvMkq-MlnS_qjxfEYfoLKOZMfYeJTaEVTJuYj4";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/oauth2/token"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$response = curl_exec($ch);
if (empty($response)) {
    die(json_encode(['error' => 'Không nhận được phản hồi từ PayPal']));
}

$json = json_decode($response);
$accessToken = $json->access_token;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v2/checkout/orders");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $accessToken
]);

$request = json_decode(file_get_contents('php://input'), true);
$total = isset($request['total']) ? $request['total'] : 0;

$amountUSD = number_format($total / 23000, 2, '.', ''); 

$orderData = [
    "intent" => "CAPTURE",
    "purchase_units" => [
        [
            "amount" => [
                "currency_code" => "USD",
                "value" => $amountUSD
            ]
        ]
    ]
];

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));

$response = curl_exec($ch);
if (empty($response)) {
    die(json_encode(['error' => 'Không nhận được phản hồi từ PayPal']));
}

echo $response;
?>
