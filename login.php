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
        <div style="position: relative; display: flex; align-items: center;">
            <input type="password" id="contrasena" name="contrasena" required style="width: 100%; padding-right: 40px;">
            <button type="button" id="togglePassword" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; font-size: 1.2rem; color: var(--purpuraOscuro);">
                <i class='bx bx-show'></i>
            </button>
        </div>

        <div class="contenedorEnlaceReset">
            <a href="solicitar_reset.php" class="linkOlvido">¿Has olvidado tu contraseña?</a>
        </div>

        <button type="submit" class="btnEnvio">Acceder</button>
    </form>
        
</div>

</main>

<?php include 'footer.php'; ?>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#contrasena');
    const icon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        icon.classList.toggle('bx-show');
        icon.classList.toggle('bx-hide');
    });
</script>

</body>
</html>