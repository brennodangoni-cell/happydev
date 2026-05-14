<?php
header('Content-Type: application/json; charset=utf-8');
$phone = $_GET['phone'] ?? '';
if ($phone === '') {
    echo json_encode(["urlImage" => null]);
    exit;
}
$phone = trim($phone);
$phone = str_replace(' ', '', $phone);
$phone = preg_replace('/[^0-9]/', '', $phone);
$url = "https://api.example.com/profile-picture-endpoint";
$payload = json_encode([
    "number" => $phone,
    "preview" => false
]);
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Content-Type: application/json",
        "token: PROFILE_API_TOKEN_PLACEHOLDER"
    ],
]);
$response = curl_exec($curl);
if ($response === false) {
    curl_close($curl);
    echo json_encode(["urlImage" => null]);
    exit;
}
curl_close($curl);
$data = json_decode($response, true);
$link = $data['image'] ?? $data['imagePreview'] ?? null;
echo json_encode(["urlImage" => $link]);
exit;
