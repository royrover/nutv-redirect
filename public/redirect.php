<?php
$slug = $_GET['slug'] ?? '';
$token = $_GET['token'] ?? '';

// ตรวจสอบว่า slug กับ token ถูกส่งมา
if (!$slug || !$token) {
    http_response_code(400);
    echo "❌ Missing slug or token.";
    exit;
}

// ดึงจากฐานข้อมูล หรือเขียน mock ไว้ก่อน
// ตัวอย่างชั่วคราว
$links = [
    "GBbNEgq7" => [
        "token" => "9TFIkdu2K2zg",
        "final_url" => "https://www.dropbox.com/scl/fi/a8tbr4z81su1f56ghgxlf/GBbNEgq7.json?rlkey=vrz84m15lt8ydjs8qzdcxzecz&st=o327g1n7&raw=1"
    ]
];

if (!isset($links[$slug])) {
    http_response_code(404);
    echo "❌ Slug not found.";
    exit;
}

if ($links[$slug]['token'] !== $token) {
    http_response_code(403);
    echo "❌ Invalid token.";
    exit;
}

header("Location: " . $links[$slug]['final_url']);
exit;
?>
