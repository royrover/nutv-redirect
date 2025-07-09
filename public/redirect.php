<?php
// redirect.php

$slug = $_GET['slug'] ?? '';
$token = $_GET['token'] ?? '';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

// ตรวจสอบ slug และ token เบื้องต้น
if (!$slug || !$token) {
    http_response_code(400);
    exit;
}

// ตัวอย่าง mock database
$links = [
    "GBbNEgq7" => [
        "token" => "9TFIkdu2K2zg",
        "final_url" => "https://www.dropbox.com/scl/fi/a8tbr4z81su1f56ghgxlf/GBbNEgqz.json?rlkey=vrz84m15lt8ydjs8qzdcxzecz&raw=1"
    ]
];

// เช็ค slug และ token
if (!isset($links[$slug]) || $links[$slug]['token'] !== $token) {
    http_response_code(403);
    exit;
}

// รายชื่อ User-Agent ที่อนุญาต (แอป IPTV ยอดนิยม)
$allowedAgents = [
    'Wiseplay',
    'Wiseplay/2.0',
    'VLC',
    'Kodi',
    'IPTV',
    'ExoPlayer',
];

// ตรวจสอบ User-Agent ว่าอยู่ในรายชื่ออนุญาตหรือไม่
$isAllowed = false;
foreach ($allowedAgents as $agent) {
    if (stripos($userAgent, $agent) !== false) {
        $isAllowed = true;
        break;
    }
}

// ตรวจสอบว่า User-Agent เป็น browser ทั่วไปหรือไม่
$isBrowser = preg_match('/Chrome|Safari|Firefox|Edg|Opera|Mozilla/i', $userAgent);

// ถ้าเป็น browser หรือ User-Agent ไม่อนุญาตให้ redirect ไป Google
if ($isBrowser || !$isAllowed) {
    header("Location: https://www.google.com");
    exit;
}

// ถ้า User-Agent ผ่าน และ token ถูกต้อง ให้ redirect ไปลิงก์จริง
header("Location: " . $links[$slug]['final_url']);
exit;
?>
