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

        $stmt = $pdo->prepare("SELECT idDispositivo, bloqueado FROM comentaristas WHERE token = ?");
        $stmt->execute([$token]);
        $dispositivo = $stmt->fetch();

        if (!$dispositivo) {
            $ins = $pdo->prepare("INSERT INTO comentaristas (token) VALUES (?)");
            $ins->execute([$token]);
            $idDispositivo = $pdo->lastInsertId();
        } else {
            $idDispositivo = $dispositivo['idDispositivo'];

            if ($dispositivo['bloqueado'] == 1) {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Este dispositivo ha sido bloqueado por la administración por intentar publicar contenido inadecuado.'
                ]);
                $pdo->rollBack();
                exit;
            }
        }

        $sqlCom = "INSERT INTO comentarios (idMemoria, idDispositivo, nombre, texto, estadoPublicacion) VALUES (?, ?, ?, ?, 0)";
        $pdo->prepare($sqlCom)->execute([$idMemoria, $idDispositivo, $nombre, $texto]);

        $pdo->commit();

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
            $mail->setFrom(SMTP_FROM, SMTP_NAME);
            
            $mail->addAddress(SMTP_USER); 
            
            $sqlAdmins = "SELECT email FROM administradoras";
            $stmtAdmins = $pdo->query($sqlAdmins);
            $listaAdmins = $stmtAdmins->fetchAll(PDO::FETCH_COLUMN);

            foreach ($listaAdmins as $correoAdmin) {
                if ($correoAdmin !== SMTP_USER) {
                    $mail->addBcc($correoAdmin);
                }
            }
            $mail->addAddress(SMTP_USER); 
            
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "Nuevo comentario de $nombre para moderar";
            $enlaceModeracion = BASE_URL . '/admin/comentariosAdmin.php';
            
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;'>
                    <div style='background-color: #800080; color: #ffffff; padding: 20px; text-align: center;'>
                        <h2 style='margin: 0;'>Nuevo comentario requiere revisión</h2>
                    </div>
                    <div style='padding: 20px; background-color: #ffffff;'>
                        <p>Compañeras, hay un nuevo comentario esperando aprobación en la web.</p>
                        <div style='background-color: #f5f5f5; padding: 15px; border-left: 4px solid #800080; margin: 20px 0;'>
                            <p style='margin: 0 0 10px 0;'><strong>Alias:</strong> $nombre</p>
                            <p style='margin: 0;'><strong>Comentario:</strong><br>$texto</p>
                        </div>
                        <p>Para aprobar o rechazar este comentario, pulsa en el botón de abajo para ir directamente al panel de gestión de comentarios:</p>
                        <br>
                        <div style='text-align: center;'>
                            <a href='$enlaceModeracion' style='display: inline-block; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Ir al Panel de Moderación</a>
                        </div>
                    </div>
                </div>
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