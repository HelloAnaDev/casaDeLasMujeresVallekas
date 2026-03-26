<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// 1. SEGURIDAD
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../config/config.php';
require_once '../libs/PHPMailer/src/Exception.php';
require_once '../libs/PHPMailer/src/PHPMailer.php';
require_once '../libs/PHPMailer/src/SMTP.php';

// 2. PROCESAMIENTO DE DATOS (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idAdmin = $_SESSION['idAdmin'];

    // --- Guardar Nombre ---
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

    // --- Guardar Email y Enviar Notificación con PHPMailer ---
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

    // --- Guardar Contraseña ---
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

// 3. OBTENER DATOS ACTUALES
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

</body>
</html>