<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once 'config/config.php';
require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!empty($email)) {
        $sql = "SELECT idAdmin, password FROM administradoras WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $expira = time() + 3600;
            $payload = $admin['idAdmin'] . '|' . $expira;
            
            $firma = hash_hmac('sha256', $payload, SECRET_KEY . $admin['password']);
            $token = base64_encode($payload . '|' . $firma);

            $enlaceRecuperacion = BASE_URL . "reset_password.php?token=" . urlencode($token);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom (SMTP_USER, 'La Casa de Mujeres de Vallekas');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Recuperacion de contraseña - Area de Administración';
                
                $mail->Body = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px;">
                    <h2 style="color: #333; text-align: center;">Recuperación de acceso</h2>
                    <p style="color: #555; font-size: 16px;">Hola,</p>
                    <p style="color: #555; font-size: 16px;">Has solicitado restablecer tu contraseña para acceder al área de administración de la Casa de Mujeres de Vallekas.</p>
                    <p style="color: #555; font-size: 16px;">Haz click en el siguiente botón para crear una nueva contraseña. Por seguridad, este enlace caducara en 1 hora.</p>
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="' . $enlaceRecuperacion . '" style="background-color: #d5b3d6; color: #080000; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;">Restablecer mi contraseña</a>
                    </div>
                    <p style="color: #777; font-size: 14px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
                        Si no has solicitado este cambio, puedes ignorar este correo de forma segura. Tu cuenta seguirá protegida.
                    </p>
                </div>';

                $mail->send();
                $mensaje = "Si el correo existe en nuestra base de datos, hemos enviado un enlace de recuperación.";

            } catch (Exception $e) {
                $mensaje = "Error del servidor al intentar enviar el correo. Por favor, intentalo más tarde.";
            }
        } else {
            $mensaje = "Si el correo existe en nuestra base de datos, hemos enviado un enlace de recuperación.";
        }
    } else {
        $mensaje = "Por favor, introduce tu email.";
    }
}

$pagina = 'recuperar';
include 'header.php';
?>

<main>
    <div id="userContrasena">
        <h2>Recuperar contraseña</h2>
        
        <?php if ($mensaje): ?>
            <p class="mensajeInfo"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <form method="POST" action="solicitar_reset.php">
            <p>Introduce tu email y te enviaremos instrucciones para crear una nueva contraseña.</p>
            <label for="email">Email de usuaria</label>
            <input type="email" id="email" name="email" required>
            <button type="submit" class="btnEnvio">Enviar correo de recuperación</button>
        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>