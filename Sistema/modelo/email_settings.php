<?php 

require_once 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->Port = '587';
$mail->CharSet = 'UTF-8';
$mail->isHTML(true);
$mail->Username = 'jdepcb@azc.uam.mx';
$mail->Password = '85ra205per749';
//emisor
$mail->setFrom('jdepcb@azc.uam.mx','JEFATURA DE CIENCIAS BÁSICAS');

 ?>