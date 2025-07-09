<?php
// redirect.php

$slug = $_GET['slug'] ?? '';
$token = $_GET['token'] ?? '';

// ❌ ตรวจไม่ผ่าน → ส่ง HTTP code อย่างเดียว ไม่มี echo ใด ๆ
if (!$slug || !$token) {
    http_response_code(400);
    exit;
}

// 🔒 mock database
$links = [
    "GBbNEgq7" => [
        "token" => "9TFIkdu2K2zg",
        "final_url" => "https://www.dropbox.com/scl/fi/a8tbr4z81su1f56ghgxlf/GBbNEgq7.json?rlkey=vrz84m15lt8ydjs8qzdcxzecz&st=o327g1n7&raw=1"
    ]
];

// ❌ slug ไม่พบ
if (!isset($links[$slug])) {
    http_response_code(404);
    exit;
}

// ❌ token ไม่ถูกต้อง
if ($links[$slug]['token'] !== $token) {
    http_response_code(403);
    exit;
}

// ✅ redirect โดยไม่ echo อะไรเลย
header("Location: " . $links[$slug]['final_url']);
exit;
?>
