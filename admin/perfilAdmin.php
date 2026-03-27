<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../libs/PHPMailer/src/Exception.php';
require_once '../libs/PHPMailer/src/PHPMailer.php';
require_once '../libs/PHPMailer/src/SMTP.php';

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAdmin = $_SESSION['idAdmin'];

if (isset($_POST['btn_dar_baja'])) {
    $passBaja = $_POST['pass_baja'];
    $idAdminSesion = $_SESSION['idAdmin'];

    $sqlComprobar = "SELECT email, nombre, password FROM administradoras WHERE idAdmin = ?";
    $stmtComprobar = $pdo->prepare($sqlComprobar);
    $stmtComprobar->execute([$idAdminSesion]);
    $datosAdmin = $stmtComprobar->fetch(PDO::FETCH_ASSOC);

    if ($datosAdmin && password_verify($passBaja, $datosAdmin['password'])) {
        $email = $datosAdmin['email'];
        $nombre = $datosAdmin['nombre'];

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
            $mail->Subject = 'Confirmación de baja - La Casa de Mujeres de Vallekas';
            
            $mail->Body = "
                <style>
                    .contenedor-email { font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
                    .cabecera-baja { background-color: #4a4a4a; color: #ffffff; padding: 20px; text-align: center; }
                    .cabecera-baja h2 { margin: 0; }
                    .cuerpo-email { padding: 20px; background-color: #ffffff; }
                    .caja-info { background-color: #f9f9f9; padding: 15px; border-left: 4px solid #800080; margin: 20px 0; }
                </style>
                <div class='contenedor-email'>
                    <div class='cabecera-baja'>
                        <h2>Hasta pronto, $nombre</h2>
                    </div>
                    <div class='cuerpo-email'>
                        <p>Te escribimos para confirmarte que tu perfil de administradora ha sido eliminado correctamente de nuestro sistema.</p>
                        <div class='caja-info'>
                            <p style='margin: 0;'>De acuerdo con nuestro compromiso con la privacidad, todos tus datos de acceso han sido borrados de nuestra base de datos.</p>
                        </div>
                        <p>Gracias por el tiempo y el trabajo voluntario que has dedicado a la Casa
                        <p>Un abrazo,<br><strong>La Casa de Mujeres de Vallekas</strong></p>
                    </div>
                </div>
            ";
            $mail->send();
        } catch (Exception $e) {
            error_log("Error enviando email de baja a $email: {$mail->ErrorInfo}");
        }

        $sqlDelete = "DELETE FROM administradoras WHERE idAdmin = ?";
        $stmtDelete = $pdo->prepare($sqlDelete);
        
        if ($stmtDelete->execute([$idAdminSesion])) {
            session_destroy();
            header("Location: ../index.php?mensaje=baja_correcta");
            exit(); 
        }
        
    } else {
        header("Location: perfilAdmin.php?error=pass");
        exit();
    }
}

    if (isset($_POST['btn_actualizar_nombre'])) {
        $nuevoNombre = trim($_POST['nuevo_nombre']);
        if (!empty($nuevoNombre)) {
            $stmt = $pdo->prepare("UPDATE administradoras SET nombre = ? WHERE idAdmin = ?");
            if ($stmt->execute([$nuevoNombre, $idAdmin])) {
                $_SESSION['nombreAdmin'] = $nuevoNombre; 
            }
        }
        header("Location: perfilAdmin.php", true, 303); 
        exit;
    }

    if (isset($_POST['btn_actualizar_email'])) {
        $nuevoEmail = trim($_POST['nuevo_email']);
        
        if (!empty($nuevoEmail) && filter_var($nuevoEmail, FILTER_VALIDATE_EMAIL)) {
            $stmt = $pdo->prepare("UPDATE administradoras SET email = ? WHERE idAdmin = ?");
            
            if ($stmt->execute([$nuevoEmail, $idAdmin])) {
                $_SESSION['emailAdmin'] = $nuevoEmail;
                
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
                    $mail->addAddress($nuevoEmail); 

                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = 'Actualizacion de correo - La Casa de Mujeres de Vallekas';
                    $mail->Body    = "<h2 style='color: #b59fce;'>Actualización de datos</h2>
                                      <p>Hola,</p>
                                      <p>Te confirmamos que tu <strong>dirección de correo electrónico</strong> ha sido actualizada con éxito.</p>
                                      <hr>
                                      <p>La Casa de Mujeres de Vallekas.</p>";
                    
                    $mail->send();
                } catch (Exception $e) {}
            }
        }
        header("Location: perfilAdmin.php", true, 303);
        exit;
    }

    if (isset($_POST['btn_actualizar_pass'])) {
        $passActual = $_POST['pass_actual'];
        $passNueva = $_POST['pass_nueva'];
        $passConfirmar = $_POST['pass_confirmar'];

        if ($passNueva === $passConfirmar && !empty($passNueva)) {
            $stmt = $pdo->prepare("SELECT password FROM administradoras WHERE idAdmin = ?");
            $stmt->execute([$idAdmin]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($passActual, $admin['password'])) {
                $nuevoHash = password_hash($passNueva, PASSWORD_DEFAULT);
                $stmtUpdate = $pdo->prepare("UPDATE administradoras SET password = ? WHERE idAdmin = ?");
                $stmtUpdate->execute([$nuevoHash, $idAdmin]);
            }
        }
        header("Location: perfilAdmin.php", true, 303);
        exit;
    }
}

$idAdmin = $_SESSION['idAdmin'];
try {
    $sql = "SELECT email FROM administradoras WHERE idAdmin = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $idAdmin]);
    $adminData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}

$emailAdmin = $_SESSION['emailAdmin'] ?? ($adminData['email'] ?? 'No disponible');

$pagina = 'perfilAdmin';
include 'sidebarHeader.php';
?>

<div class="contenedorPerfilAdmin">
    
    <div class="cabeceraPerfil">
        <h2 class="saludoPerfil">¡Hola, <?php echo htmlspecialchars($_SESSION['nombreAdmin']); ?>! <br>Bienvenida a tu perfil</h2>
        
        <div class="botonesPrincipales">
            <button type="button" class="btnPerfil" onclick="document.getElementById('modalNombre').showModal()">Cambiar nombre</button>
        </div>
    </div>

    <div class="seccionDatos">
        <h3>Datos de acceso:</h3>
        
        <div class="filaDato">
            <p>Email: <strong><?php echo htmlspecialchars($emailAdmin); ?></strong></p>
            <button class="btnPerfil secundario" onclick="document.getElementById('modalEmail').showModal()">Cambiar dirección de correo</button>
        </div>
        
        <div class="filaDato">
            <button class="btnPerfil secundario" onclick="document.getElementById('modalPassword').showModal()">Cambiar contraseña</button>
        </div>
    </div>

    <div class="seccionAlta">
        <h3>¿Necesitas dar de alta a una compañera?</h3>
        <p>En caso afirmativo, <a href="registroAdmin.php" class="enlaceAlta">haz click aquí</a></p>
    </div>

    <div class="seccionAlta separacionSuperior">
        <h3>¿Necesitas dar de baja tu perfil?</h3>
        <p>En caso afirmativo, <a href="#" onclick="event.preventDefault(); document.getElementById('modalBaja').showModal();" class="enlaceAlta enlaceBaja">haz click aquí</a></p>
        
        <?php if (isset($_GET['error']) && $_GET['error'] === 'pass'): ?>
            <p class="mensajeErrorBaja">Contraseña incorrecta. Baja cancelada.</p>
        <?php endif; ?>
    </div>

</div>

<dialog id="modalNombre" class="modalPerfil">
    <form method="POST" action="perfilAdmin.php">
        <h3>Actualizar Nombre</h3>
        <label for="nuevo_nombre">Nuevo nombre:</label>
        <input type="text" id="nuevo_nombre" name="nuevo_nombre" required value="<?php echo htmlspecialchars($_SESSION['nombreAdmin']); ?>">
        <div class="botonesModal">
            <button type="button" class="btnCancelar" onclick="document.getElementById('modalNombre').close()">Cancelar</button>
            <button type="submit" name="btn_actualizar_nombre" class="btnGuardar">Guardar cambios</button>
        </div>
    </form>
</dialog>

<dialog id="modalEmail" class="modalPerfil">
    <form method="POST" action="perfilAdmin.php">
        <h3>Actualizar Email</h3>
        <label for="nuevo_email">Nuevo email:</label>
        <input type="email" id="nuevo_email" name="nuevo_email" required value="<?php echo htmlspecialchars($emailAdmin); ?>">
        <div class="botonesModal">
            <button type="button" class="btnCancelar" onclick="document.getElementById('modalEmail').close()">Cancelar</button>
            <button type="submit" name="btn_actualizar_email" class="btnGuardar">Guardar cambios</button>
        </div>
    </form>
</dialog>

<dialog id="modalPassword" class="modalPerfil">
    <form method="POST" action="perfilAdmin.php">
        <h3>Actualizar Contraseña</h3>
        <label for="pass_actual">Contraseña actual:</label>
        <input type="password" name="pass_actual" required>
        <label for="pass_nueva">Nueva contraseña:</label>
        <input type="password" name="pass_nueva" required minlength="6">
        <label for="pass_confirmar">Confirmar nueva contraseña:</label>
        <input type="password" name="pass_confirmar" required minlength="6">
        <div class="botonesModal">
            <button type="button" class="btnCancelar" onclick="document.getElementById('modalPassword').close()">Cancelar</button>
            <button type="submit" name="btn_actualizar_pass" class="btnGuardar">Guardar cambios</button>
        </div>
    </form>
</dialog>

<dialog id="modalBaja" class="modalPerfil">
    <form method="POST" action="perfilAdmin.php">
        <div class="cabeceraModalPeligro">
            <h3 class="tituloPeligro gigante">ZONA DE PELIGRO</h3>
            <p class="textoAviso">Estás a punto de eliminar tu cuenta permanentemente. Perderás el acceso a la administración y esta acción NO se puede deshacer.</p>
        </div>
        
        <label for="pass_baja" class="labelPeligro">Para continuar, introduce tu contraseña actual:</label>
        <input type="password" name="pass_baja" id="pass_baja" required class="inputPeligro">
        
        <div class="botonesModal botonesColumna">
            <button type="button" class="btnGuardar btnVolverAtras" onclick="document.getElementById('modalBaja').close()">SÍ QUIERO MI PERFIL, VOLVER ATRÁS</button>
            <button type="submit" name="btn_dar_baja" class="btnGuardar btnPeligro">DAR DE BAJA DEFINITIVAMENTE</button>
        </div>
    </form>
</dialog>

</body>
</html>