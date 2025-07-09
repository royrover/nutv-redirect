<?php
$slug = $_GET['slug'] ?? '';
$token = $_GET['token'] ?? '';
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$headerNUtvToken = $_SERVER['HTTP_X_NUTV_TOKEN'] ?? '';

// ตรวจสอบ slug และ token เบื้องต้น
if (!$slug || !$token) {
    http_response_code(400);
    exit;
}

// ตัวอย่าง mock DB พร้อมวันที่หมดอายุ token
$links = [
    "GBbNEgq7" => [
        "token" => "9TFIkdu2K2zg",
        "expires" => strtotime('2025-12-31'),
        "final_url" => "https://dropbox.link/..."
    ]
];

// เช็ค slug token
if (!isset($links[$slug]) || $links[$slug]['token'] !== $token) {
    http_response_code(403);
    exit;
}

// เช็ควันหมดอายุ token
if (time() > $links[$slug]['expires']) {
    http_response_code(403);
    exit;
}

// เช็ค User-Agent whitelist (แอป IPTV)
$allowedAgents = ['Wiseplay', 'VLC', 'Kodi', 'IPTV', 'ExoPlayer'];
$isAllowedAgent = false;
foreach ($allowedAgents as $agent) {
    if (stripos($userAgent, $agent) !== false) {
        $isAllowedAgent = true;
        break;
    }
}

// เช็ค Referer (ถ้าเปิดจาก browser ให้ redirect Google)
$isBrowser = preg_match('/Chrome|Safari|Firefox|Edg|Opera|Mozilla/i', $userAgent);

if ($isBrowser || !$isAllowedAgent) {
    // ไม่ผ่านเงื่อนไข ให้ไป Google
    header("Location: https://www.google.com");
    exit;
}

// (ถ้าอยากตรวจ header ลับ)
if ($headerNUtvToken !== 'your_secret_token_here') {
    http_response_code(403);
    exit;
}

// redirect สู่ final url
header("Location: " . $links[$slug]['final_url']);
exit;
?>
