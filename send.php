<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://avtodor.pro');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['ok' => false]));
}

$name  = htmlspecialchars(trim($_POST['name']  ?? ''), ENT_QUOTES);
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES);
$task  = htmlspecialchars(trim($_POST['task']  ?? ''), ENT_QUOTES);

if (!$name || !$phone) {
    http_response_code(400);
    exit(json_encode(['ok' => false, 'error' => 'missing fields']));
}

$to      = 'n.dudko@avtodor.pro';
$subject = '=?UTF-8?B?' . base64_encode('Новая заявка с сайта') . '?=';
$body    = "Имя: $name\nТелефон: $phone\nЗадача: $task";
$headers = "From: noreply@avtodor.pro\r\nContent-Type: text/plain; charset=UTF-8";

$sent = mail($to, $subject, $body, $headers);
echo json_encode(['ok' => $sent]);
