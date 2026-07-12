<?php
header('Content-Type: application/json');

$to = "terase@lux-terra.md, cristafovici.den@gmail.com";

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($name) || empty($phone)) {
  echo json_encode(['ok' => false, 'error' => 'Numele și telefonul sunt obligatorii.']);
  exit;
}

$subject = "=?UTF-8?B?" . base64_encode("Cerere ofertă LuxTerra") . "?=";

$body = "Nume: $name\n";
$body .= "Telefon: $phone\n";
if ($email) $body .= "Email: $email\n";
$body .= "Mesaj: $message\n";

$headers = "From: LuxTerra <noreply@lux-terra.md>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$ok = mail($to, $subject, $body, $headers);
echo json_encode(['ok' => $ok, 'error' => $ok ? '' : 'Eroare la trimitere. Încearcă mai târziu.']);
