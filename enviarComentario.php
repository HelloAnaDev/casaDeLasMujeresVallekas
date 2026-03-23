<?php
require_once 'config/db.php';
require_once 'config/config.php';
require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$idMemoria = $_POST['idMemoria'];
    $nombre = strip_tags(trim($_POST['nombre'])); 
    $texto = strip_tags(trim($_POST['texto']));   
    $token = $_POST['token'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT idDispositivo FROM comentaristas WHERE token = ?");
        $stmt->execute([$token]);
        $dispositivo = $stmt->fetch();

        if (!$dispositivo) {
            $ins = $pdo->prepare("INSERT INTO comentaristas (token) VALUES (?)");
            $ins->execute([$token]);
            $idDispositivo = $pdo->lastInsertId();
        } else {
            $idDispositivo = $dispositivo['idDispositivo'];

            $sqlCheck = "SELECT COUNT(*) FROM comentarios WHERE idDispositivo = ? AND estadoPublicacion = 2";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([$idDispositivo]);
            $rechazados = $stmtCheck->fetchColumn();

            if ($rechazados >= 3) {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Este dispositivo ha sido bloqueado por publicar contenido inadecuado repetidamente.'
                ]);
                $pdo->rollBack();
                exit;
            }
        }

        $sqlCom = "INSERT INTO comentarios (idMemoria, idDispositivo, nombre, texto, estadoPublicacion) VALUES (?, ?, ?, ?, 0)";
        $pdo->prepare($sqlCom)->execute([$idMemoria, $idDispositivo, $nombre, $texto]);

        $pdo->commit();

        // --- INICIO BLOQUE PHPMAILER ---
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->Port       = SMTP_PORT;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            
            $mail->setFrom(SMTP_FROM, SMTP_NAME);
            $mail->addAddress(SMTP_USER); // (el correo al que llega el aviso de que hay comentarios que moderar)
            
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "Nuevo comentario de $nombre para moderar";
            $mail->Body = "
                <h2 style='color: #800080;'>Nuevo comentario requiere revisión</h2>
                <p>Compañeras, hay un nuevo comentario oculto esperando aprobación en la web.</p>
                <p><strong>Alias:</strong> $nombre</p>
                <p><strong>Comentario:</strong><br>$texto</p>
                <hr>
                <p>Entrad al panel de administración para gestionarlo.</p>
            ";
            $mail->send();
        } catch (Exception $e) {
                    }
        echo json_encode(['status' => 'success', 'message' => 'Comentario enviado. Aparecerá cuando sea revisado por moderación.']);

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo json_encode(['status' => 'error', 'message' => 'Error en el sistema: ' . $e->getMessage()]);
    }
}
?>