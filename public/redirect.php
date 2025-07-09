<?php
$slug = $_GET['slug'] ?? '';
$token = $_GET['token'] ?? '';

if (!$slug || !$token) {
    http_response_code(400);
    exit;
}

// mock DB
$links = [
    "GBbNEgq7" => [
        "token" => "9TFIkdu2K2zg",
        "final_url" => "https://www.dropbox.com/scl/fi/a8tbr4z81su1f56ghgxlf/GBbNEgq7.json?rlkey=vrz84m15lt8ydjs8qzdcxzecz&st=ejo0nkkj&raw=1"
    ]
];

if (!isset($links[$slug]) || $links[$slug]['token'] !== $token) {
    http_response_code(403);
    exit;
}

// ✅ ไม่มี echo, ไม่มี print, ไม่มี readfile
header("Location: " . $links[$slug]['final_url']);
exit;

?>
