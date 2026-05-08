<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://avtodor.pro');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['ok' => false]));
}

$question = htmlspecialchars(trim($_POST['question'] ?? ''), ENT_QUOTES);
$phone    = htmlspecialchars(trim($_POST['phone']    ?? ''), ENT_QUOTES);
$email    = htmlspecialchars(trim($_POST['email']    ?? ''), ENT_QUOTES);

if (!$question || !$phone || !$email) {
    http_response_code(400);
    exit(json_encode(['ok' => false, 'error' => 'missing fields']));
}

$to      = 'n.dudko@avtodor.pro';
$subject = '=?UTF-8?B?' . base64_encode('Вопрос с сайта (чат)') . '?=';
$body    = "Вопрос: $question\nТелефон: $phone\nEmail: $email";
$headers = "From: noreply@avtodor.pro\r\nContent-Type: text/plain; charset=UTF-8";

$sent = mail($to, $subject, $body, $headers);
echo json_encode(['ok' => $sent]);
