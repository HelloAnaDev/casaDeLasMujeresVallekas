<?php
session_start();

require_once 'config/config.php';

$error = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['contrasena'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Por favor, rellena todos los campos.';
    } else {
        $sql = "SELECT * FROM administradoras WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            
            $_SESSION['idAdmin'] = $admin['idAdmin'];
            $_SESSION['nombreAdmin'] = $admin['nombre'];
            $_SESSION['rol'] = 'admin';

            header('Location: admin/inicioAdmin.php');
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
        }
    }
}

$pagina='login';
include 'header.php';
?>

<main>

<div id="userContrasena">
    
    <?php if ($error): ?>
        <p class="mensajeError"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="email">Email de usuaria</label>
        <input type="email" id="email" name="email" required>
            
        <label for="contrasena">Contraseña</label>
        <div style="position: relative;">
            <input type="password" id="contrasena" name="contrasena" required style="width: 100%; padding-right: 80px; box-sizing: border-box;">
            <button type="button" id="btnTogglePsw" style="position: absolute; right: 10px; top: 12px; background: none; border: none; cursor: pointer; color: var(--purpuraOscuro); font-weight: bold; font-family: 'Poppins', sans-serif; font-size: 0.85rem;">Mostrar</button>
        </div>

        <script>
        document.getElementById('btnTogglePsw').addEventListener('click', function() {
            const input = document.getElementById('contrasena');
            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = 'Ocultar';
            } else {
                input.type = 'password';
                this.textContent = 'Mostrar';
            }
        });
        </script>

        <div class="contenedorEnlaceReset">
            <a href="solicitar_reset.php" class="linkOlvido">¿Has olvidado tu contraseña?</a>
        </div>

        <button type="submit" class="btnEnvio">Acceder</button>
    </form>
        
</div>

</main>

<?php include 'footer.php'; ?>

</body>
</html>