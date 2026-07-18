<?php
header('Content-Type: application/json');

$to = "terase@lux-terra.md";

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($name) || empty($phone)) {
  echo json_encode(['ok' => false, 'error' => 'Numele și telefonul sunt obligatorii.']);
  exit;
}

$subject = "=?UTF-8?B?" . base64_encode("Cerere ofertă LuxTerra") . "?=";

$escaped = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');

$html = <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#1a1a1a;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#1a1a1a;padding:40px 20px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#0a0a0a;border-radius:12px;overflow:hidden;border:1px solid #d4a017">
<tr><td style="padding:30px 30px 10px;text-align:center;border-bottom:2px solid #d4a017">
<h1 style="color:#d4a017;margin:0;font-size:28px;letter-spacing:4px">LUXTERRA</h1>
<p style="color:#888;margin:5px 0 0;font-size:12px;letter-spacing:2px">CERERE OFERTĂ</p>
</td></tr>
<tr><td style="padding:30px">
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td style="padding:10px 0;color:#ccc;font-size:14px;border-bottom:1px solid #333"><strong style="color:#d4a017">Nume:</strong> {$escaped($name)}</td></tr>
<tr><td style="padding:10px 0;color:#ccc;font-size:14px;border-bottom:1px solid #333"><strong style="color:#d4a017">Telefon:</strong> {$escaped($phone)}</td></tr>
HTML;
if ($email) $html .= '<tr><td style="padding:10px 0;color:#ccc;font-size:14px;border-bottom:1px solid #333"><strong style="color:#d4a017">Email:</strong> ' . $escaped($email) . '</td></tr>';
$html .= <<<HTML
<tr><td style="padding:10px 0;color:#ccc;font-size:14px"><strong style="color:#d4a017">Mesaj:</strong><br><p style="color:#aaa;margin:8px 0 0;line-height:1.6">{$escaped($message)}</p></td></tr>
</table>
</td></tr>
<tr><td style="padding:15px 30px;background:#0d0d0d;text-align:center;border-top:1px solid #333">
<p style="color:#555;font-size:11px;margin:0">LuxTerra — Terase și Pergole de Lux</p>
</td></tr>
</table>
</td></tr>
</table>
</body>
</html>
HTML;

$headers = "From: LuxTerra <noreply@lux-terra.md>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$ok = mail($to, $subject, $html, $headers);
echo json_encode(['ok' => $ok, 'error' => $ok ? '' : 'Eroare la trimitere. Încearcă mai târziu.']);
