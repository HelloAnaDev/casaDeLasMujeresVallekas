<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

require_once '../libs/PHPMailer/src/Exception.php';
require_once '../libs/PHPMailer/src/PHPMailer.php';
require_once '../libs/PHPMailer/src/SMTP.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../config/config.php';

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_registrar'])) {
    
    // Limpieza de datos
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $passConfirm = $_POST['password_confirm'];

    if (empty($nombre) || empty($email) || empty($pass) || empty($passConfirm)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del correo electrónico no es válido.";
    } elseif ($pass !== $passConfirm) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($pass) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        
        $stmtCheck = $pdo->prepare("SELECT idAdmin FROM administradoras WHERE email = ?");
        $stmtCheck->execute([$email]);
        
        if ($stmtCheck->rowCount() > 0) {
            $error = "Ya existe una compañera registrada con ese correo electrónico.";
        } else {
            
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            

            $sql = "INSERT INTO administradoras (nombre, email, password) VALUES (?, ?, ?)";
            $stmtInsert = $pdo->prepare($sql);
            
            if ($stmtInsert->execute([$nombre, $email, $hash])) {
                $exito = "¡Compañera $nombre dada de alta correctamente!";
                
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
                    $mail->addAddress($email, $nombre); 

                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = 'Bienvenida al equipo - La Casa de Mujeres de Vallekas';

                    $mail->Body = "
                        <div style='font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;'>
                            <div style='background-color: #800080; color: #ffffff; padding: 20px; text-align: center;'>
                                <h2 style='margin: 0;'>¡Bienvenida a La Casa, $nombre!</h2>
                            </div>
                            <div style='padding: 20px; background-color: #ffffff;'>
                                <p>Tu perfil de administradora ha sido creado con éxito. A partir de ahora podrás gestionar las memorias y moderar comentarios en nuestra web.</p>
                                <p>Aquí tienes tus credenciales de acceso provisionales:</p>
                                <div style='background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;'>
                                    <p style='margin: 0;'><strong>Usuario (Email):</strong> $email</p>
                                    <p style='margin: 5px 0 0 0;'><strong>Contraseña temporal:</strong> $pass</p>
                                </div>
                                <p style='color: #d32f2f; font-weight: bold;'>¡Importante!</p>
                                <p>Por motivos de seguridad, te pedimos que inicies sesión y cambies esta contraseña en la sección ``Mi Perfil´´(Ubicado abajo a la izquierda una vez iniciada sesión) lo antes posible.</p>
                                <br>
                                <p>Un abrazo,<br><strong>La Casa de Mujeres de Vallekas</strong></p>
                            </div>
                        </div>
                    ";
                    
                    $mail->send();
                } catch (Exception $e) {
                    $error = "La compañera fue registrada, pero hubo un error enviando el email de bienvenida.";
                }
                // --- FIN ENVÍO EMAIL ---

            } else {
                $error = "Hubo un problema técnico al registrar a la usuaria.";
            }
        }
    }
}

$pagina = 'registroAdmin'; 
include 'sidebarHeader.php';
?>

<div class="contenedorPrincipalAdmin">
    <div class="cabeceraSeccion">
        <h2>Dar de alta a una nueva compañera</h2>
        <p>Crea un perfil de acceso para que otra voluntaria pueda gestionar la web.</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="mensajeError" style="color: red; margin-bottom: 15px;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($exito)): ?>
        <div class="mensajeExito" style="color: green; margin-bottom: 15px;">
            <?php echo htmlspecialchars($exito); ?>
        </div>
    <?php endif; ?>

    <form action="registroAdmin.php" method="POST" class="formularioGeneral">
        
        <div class="grupoInput">
            <label for="nombre">Nombre de la voluntaria:</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Ej: Laura">
        </div>

        <div class="grupoInput">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required placeholder="laura@ejemplo.com">
        </div>

        <div class="grupoInput">
            <label for="password">Contraseña provisional:</label>
            <input type="password" id="password" name="password" required minlength="6">
            <small>Asigna una clave segura. Ella podrá cambiarla luego en su perfil.</small>
        </div>

        <div class="grupoInput">
            <label for="password_confirm">Confirmar contraseña:</label>
            <input type="password" id="password_confirm" name="password_confirm" required minlength="6">
        </div>

        <div class="botonesFormulario">
            <button type="submit" name="btn_registrar" class="btnGuardar">Registrar compañera</button>
        </div>
        
    </form>
</div>

</body>
</html>