<?php
// redirect.php

$slug = $_GET['slug'] ?? '';
$token = $_GET['token'] ?? '';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

// ✅ ตรวจสอบ slug และ token
if (!$slug || !$token) {
    http_response_code(400);
    exit;
}

// ✅ mock database
$links = [
    "GBbNEgq7" => [
        "token" => "9TFIkdu2K2zg",
        "final_url" => "https://www.dropbox.com/scl/fi/a8tbr4z81su1f56ghgxlf/GBbNEgqz.json?rlkey=vrz84m15lt8ydjs8qzdcxzecz&raw=1"
    ]
];

// ✅ ตรวจสอบ slug และ token
if (!isset($links[$slug]) || $links[$slug]['token'] !== $token) {
    http_response_code(403);
    exit;
}

// ✅ รายชื่อ User-Agent ที่อนุญาต (แอป IPTV)
$allowedAgents = [
    'Wiseplay',
    'VLC',
    'Kodi',
    'IPTV',
    'ExoPlayer',
];

// ✅ ตรวจว่า User-Agent อยู่ใน whitelist หรือไม่
$isAllowed = false;
foreach ($allowedAgents as $agent) {
    if (stripos($userAgent, $agent) !== false) {
        $isAllowed = true;
        break;
    }
}

// ✅ ถ้าไม่ใช่แอปที่ whitelist หรือเป็น Browser → ส่งไป Google
$isBrowser = preg_match('/Chrome|Safari|Firefox|Edg|Opera|Mozilla/i', $userAgent);
if ($isBrowser || !$isAllowed) {
    header("Location: https://www.google.com");
    exit;
}

// ✅ redirect ไปยังลิงก์ Dropbox จริง
header("Location: " . $links[$slug]['final_url']);
exit;
?>
