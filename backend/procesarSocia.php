<?php

require_once '../config/config.php';
require '../libs/PHPMailer/src/Exception.php';
require '../libs/PHPMailer/src/PHPMailer.php';
require '../libs/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Honeypot anti-spam
    $honeypot = $_POST['sitioWebSocia'] ?? '';
    if (!empty($honeypot)) {
        header("Location: ../colabora.php?socia=success");
        exit();  
    }

    // Recoger y limpiar datos
    $nombre    = strip_tags(trim($_POST['nombre_socia'] ?? ''));
    $dni       = strip_tags(trim($_POST['dni_socia'] ?? ''));
    $telefono  = strip_tags(trim($_POST['telefono_socia'] ?? ''));
    $direccion = strip_tags(trim($_POST['direccion_socia'] ?? ''));
    $email     = filter_var(trim($_POST['email_socia'] ?? ''), FILTER_SANITIZE_EMAIL);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->Port       = SMTP_PORT;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
        $mail->setFrom(SMTP_FROM, SMTP_NAME);
        $mail->addAddress('casademujeresvk@gmail.com');
        
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail->addReplyTo($email, $nombre);
        }
        
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "NUEVA SOCIA: Solicitud de $nombre";
        
        $mail->Body = "
            <h2 style='color: #800080;'>¡Tenemos una nueva solicitud de Socia!</h2>
            <p><strong>Nombre y Apellidos:</strong> $nombre</p>
            <p><strong>DNI:</strong> $dni</p>
            <p><strong>Teléfono:</strong> $telefono</p>
            <p><strong>Dirección:</strong> $direccion</p>
            <p><strong>Correo electrónico:</strong> " . ($email ? $email : 'No proporcionado') . "</p>
            <hr>
            <p style='font-size: 12px; color: #666;'>Esta solicitud fue enviada aceptando la política de privacidad (RGPD).</p>";
            
        $mail->send();
        header("Location: ../colabora.php?socia=success#sec-socias");
        exit();

    } catch (Exception $e) {
        header("Location: ../colabora.php?socia=error#sec-socias");
        exit();
    }
} else {
    header("Location: ../colabora.php");
    exit();
}
?>