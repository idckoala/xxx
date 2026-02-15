<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain; charset=utf-8");

$url = $_GET['url'] ?? '';
if (!$url) {
    http_response_code(400);
    exit('0');
}

$context = stream_context_create([
    "http" => [
        "timeout" => 5
    ]
]);

$data = @file_get_contents($url, false, $context);
if ($data === false) {
    exit('0');
}

echo trim($data);
