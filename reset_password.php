<?php
session_start();
require_once 'config/config.php';

$mensaje = '';
$tokenValido = false;
$idAdmin = null;
$tokenInput = $_GET['token'] ?? $_POST['token'] ?? '';

if (!empty($tokenInput)) {
    $tokenDecodificado = base64_decode($tokenInput);
    $partes = explode('|', $tokenDecodificado);

    if (count($partes) === 3) {
        $idAdmin = (int)$partes[0];
        $expira = (int)$partes[1];
        $firmaRecibida = $partes[2];

        if (time() <= $expira) {
            $sql = "SELECT password FROM administradoras WHERE idAdmin = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $idAdmin]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $payload = $idAdmin . '|' . $expira;
                $firmaCalculada = hash_hmac('sha256', $payload, SECRET_KEY . $admin['password']);

                if (hash_equals($firmaCalculada, $firmaRecibida)) {
                    $tokenValido = true;
                } else {
                    $mensaje = "El enlace no es valido o ya ha sido utilizado.";
                }
            } else {
                $mensaje = "Usuaria no encontrada.";
            }
        } else {
            $mensaje = "El enlace ha caducado. Por favor, solicita uno nuevo.";
        }
    } else {
        $mensaje = "Token de seguridad malformado.";
    }
} else {
    $mensaje = "No se ha proporcionado ningun token de seguridad.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValido) {
    $nuevaContrasena = $_POST['nuevaContrasena'] ?? '';
    $repetirContrasena = $_POST['repetirContrasena'] ?? '';

    if (strlen($nuevaContrasena) < 8) {
        $mensaje = "La contraseña debe tener al menos 8 caracteres.";
    } elseif ($nuevaContrasena !== $repetirContrasena) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        $hashNuevo = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE administradoras SET password = :password WHERE idAdmin = :id";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([':password' => $hashNuevo, ':id' => $idAdmin])) {
            $mensaje = "Contrasena actualizada con exito. <a href='login.php' class='linkLogin'>Ir al login</a>";
            $tokenValido = false; 
        } else {
            $mensaje = "Hubo un error interno al actualizar la contraseña.";
        }
    }
}

$pagina = 'reset';
include 'header.php';
?>

<main>
    <div id="userContrasena">
        <h2>Restablecer contraseña</h2>
        
        <?php if ($mensaje): ?>
            <p class="mensajeInfo"><?php echo $mensaje; ?></p>
        <?php endif; ?>

        <?php if ($tokenValido): ?>
            <form method="POST" action="reset_password.php">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($tokenInput); ?>">
                
                <label for="nuevaContrasena">Nueva contraseña</label>
                <input type="password" id="nuevaContrasena" name="nuevaContrasena" required minlength="8">
                
                <label for="repetirContrasena">Repetir contraseña</label>
                <input type="password" id="repetirContrasena" name="repetirContrasena" required minlength="8">
                
                <button type="submit" class="btnEnvio">Guardar nueva contraseña</button>
            </form>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>