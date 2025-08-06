<?php
// 🔐 ใส่ API Key จริงของคุณตรงนี้ (หาจาก https://developer.thaibulksms.com)
$api_key = 'demoAPIkey';
$api_secret = 'demoAPIsecret';  // ใส่จริงตรงนี้

// รับข้อมูลจากฟอร์ม
$phone = $_POST['phone'] ?? '';
$message = $_POST['message'] ?? '';

// ตรวจสอบข้อมูล
if (!$phone || !$message) {
  echo "❌ ข้อมูลไม่ครบ";
  exit;
}

// สร้างข้อมูลสำหรับส่ง API
$url = 'https://developer.thaibulksms.com/sms/json';
$data = [
  'msisdn' => $phone,
  'message' => $message,
  'sender' => 'THAIBULKSMS',
  'force' => 'standard'
];

// สร้าง Header + ส่งข้อมูล
$options = [
  'http' => [
    'header'  => "Content-type: application/json\r\n" .
                 "Authorization: Basic " . base64_encode("$api_key:$api_secret") . "\r\n",
    'method'  => 'POST',
    'content' => json_encode($data),
  ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// ตรวจสอบผลลัพธ์
if ($result === FALSE) {
  echo "❌ ไม่สามารถส่งได้";
} else {
  $res = json_decode($result, true);
  if ($res['status'] == 'success') {
    echo "✅ ส่งสำเร็จ";
  } else {
    echo "❌ ล้มเหลว: " . $res['description'];
  }
}
