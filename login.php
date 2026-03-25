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
        <input type="password" id="contrasena" name="contrasena" required>

        <button type="submit" class="btnEnvio">Acceder</button>
    </form>
        
</div>

</main>

<?php include 'footer.php'; ?>

</body>
</html>