<?php
session_start();

// 1. SEGURIDAD ABSOLUTA: Solo administradoras pueden crear otras administradoras
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../config/config.php';

// Variables para manejar los mensajes de la interfaz
$error = '';
$exito = '';

// 2. PROCESAMIENTO DEL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_registrar'])) {
    
    // Limpieza de datos
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $passConfirm = $_POST['password_confirm'];

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($pass) || empty($passConfirm)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del correo electrónico no es válido.";
    } elseif ($pass !== $passConfirm) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($pass) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        
        // 3. COMPROBAR DUPLICADOS (Evitar que dos voluntarias tengan el mismo email)
        $stmtCheck = $pdo->prepare("SELECT idAdmin FROM administradoras WHERE email = ?");
        $stmtCheck->execute([$email]);
        
        if ($stmtCheck->rowCount() > 0) {
            $error = "Ya existe una compañera registrada con ese correo electrónico.";
        } else {
            
            // 4. CIFRADO E INSERCIÓN
           // 4. CIFRADO E INSERCIÓN (Sin la columna 'rol')
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            
            // Insertamos solo nombre, email y contraseña
            $sql = "INSERT INTO administradoras (nombre, email, password) VALUES (?, ?, ?)";
            $stmtInsert = $pdo->prepare($sql);
            
            if ($stmtInsert->execute([$nombre, $email, $hash])) {
                $exito = "¡Compañera $nombre dada de alta correctamente!";
            } else {
                $error = "Hubo un problema técnico al registrar a la usuaria.";
            }
        }
    }
}

$pagina = 'registroAdmin'; // Para que el sidebar sepa dónde estamos
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