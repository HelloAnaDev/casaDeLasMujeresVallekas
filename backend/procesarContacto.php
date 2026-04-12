<?php

require_once '../config/config.php';
require '../libs/PHPMailer/src/Exception.php';
require '../libs/PHPMailer/src/PHPMailer.php';
require '../libs/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $honeypot = $_POST ['sitioWeb']??'';
    if (!empty($honeypot)) {
        header ("Location: ../contacto.php?status=success");
        exit();  }

$nombre=strip_tags(trim($_POST['nombre']??''));
$email=filter_var(trim($_POST['email']??''),FILTER_SANITIZE_EMAIL);
$telefono=strip_tags(trim($_POST['telefono']??''));
$medio=$_POST['medioPreferido']??'No especificado';
$mensaje=strip_tags(trim($_POST['mensaje']??''));

$mail = new PHPMailer(true);

try{
    $mail-> isSMTP();
    $mail->Host=SMTP_HOST;
    $mail->SMTPAuth=true;
    $mail->Username=SMTP_USER;
    $mail->Password=SMTP_PASS;
    $mail->Port=SMTP_PORT;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->setFrom(SMTP_FROM,SMTP_NAME);
    $mail->addAddress('casademujeresvk@gmail.com');
    if (!empty($email)) {
        $mail->addReplyTo($email, $nombre);
    }
    $mail->isHTML(true);
    $mail->CharSet='UTF-8';
    $mail->Subject="Web de La casa de las Mujeres Vallekas: Nuevo mensaje de $nombre";
    $mail->Body="<h2 style='color: #800080;'>Nueva consulta recibida</h2>
            <p><strong>Nombre:</strong> $nombre</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Teléfono:</strong> $telefono</p>
            <p><strong>Preferencia de contacto:</strong> $medio</p>
            <hr>
            <p><strong>Mensaje:</strong></p>
            <p>$mensaje</p>";
     $mail->send();
     header("Location: ../contacto.php?status=success");
     exit();



} catch (Exception $e) {
    echo "Error crítico de Google: " . $mail->ErrorInfo;
    exit();
 }
} else {
    header("Location: ../contacto.php");
    exit();
 }

?>