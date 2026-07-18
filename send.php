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

$style = <<<CSS
@media only screen and (max-width:600px){
  .et-main{width:100% !important}
  .et-inner td{display:block !important;width:100% !important;box-sizing:border-box}
  .et-inner td:first-child{border-right:none !important;border-bottom:0 !important;padding-bottom:4px !important}
  .et-inner td:last-child{padding-top:4px !important}
}
CSS;

$html = <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><style>$style</style></head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="padding:20px">
<tr><td align="center">
<table width="720" cellpadding="0" cellspacing="0" class="et-main" style="background:#0a0a0a;border-radius:12px;overflow:hidden;border:1px solid #d4a017">
<tr><td style="padding:30px 30px 18px;text-align:center;border-bottom:2px solid #d4a017">
<h1 style="color:#d4a017;margin:0;font-size:30px;letter-spacing:5px;font-weight:400">LUX<span style="font-weight:700">TERRA</span></h1>
<p style="color:#888;margin:8px 0 0;font-size:12px;letter-spacing:3px">CERERE OFERTĂ</p>
</td></tr>
<tr><td style="padding:25px 25px 40px">
<table width="100%" cellpadding="0" cellspacing="0" class="et-inner" style="border:2px solid #333;border-radius:8px">
<tr>
<td width="35%" style="padding:16px 18px;color:#d4a017;font-size:16px;font-weight:700;border-bottom:2px solid #333;border-right:2px solid #333;vertical-align:top">Nume</td>
<td width="65%" style="padding:16px 18px;color:#fff;font-size:16px;border-bottom:2px solid #333">{$escaped($name)}</td>
</tr>
<tr>
<td width="35%" style="padding:16px 18px;color:#d4a017;font-size:16px;font-weight:700;border-bottom:2px solid #333;border-right:2px solid #333;vertical-align:top">Telefon</td>
<td width="65%" style="padding:16px 18px;color:#fff;font-size:16px;border-bottom:2px solid #333">{$escaped($phone)}</td>
</tr>
HTML;

if ($email) {
  $html .= <<<HTML
<tr>
<td width="35%" style="padding:16px 18px;color:#d4a017;font-size:16px;font-weight:700;border-bottom:2px solid #333;border-right:2px solid #333;vertical-align:top">Email</td>
<td width="65%" style="padding:16px 18px;color:#fff;font-size:16px;border-bottom:2px solid #333">{$escaped($email)}</td>
</tr>
HTML;
}

$html .= <<<HTML
<tr>
<td width="35%" style="padding:16px 18px;color:#d4a017;font-size:16px;font-weight:700;border-right:2px solid #333;vertical-align:top">Mesaj</td>
<td width="65%" style="padding:16px 18px;color:#ddd;font-size:15px;line-height:1.6">{$escaped($message)}</td>
</tr>
</table>
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
