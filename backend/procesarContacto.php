<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // filtro antispam - este campo es invisible, por lo que ningún humano puede rellenarlo desde la interfaz del formulario. Si aparece relleno, significará que ha sido rellenado por un bot, así que será automaticamente descartado.
    $honeypot = $_POST['sitioWeb'] ?? '';
    
    if (!empty($honeypot)) {
        header("Location: ../contacto.html?status=success");
        exit(); 
    }

    // datos reales
    $nombre = $_POST['nombre'] ?? '';
    $medio = $_POST['medioPreferido'] ?? '';
    $email = $_POST['correo'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';
    $fechaEnvio = date('Y-m-d H:i:s');


    $sql = "INSERT INTO formulariocontacto (nombre, medioPreferido, email, telefono, mensaje, fechaEnvio) 
            VALUES (:nombre, :medio, :email, :telefono, :mensaje, :fecha)";
    
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            ':nombre' => $nombre,
            ':medio' => $medio,
            ':email' => $email,
            ':telefono' => $telefono,
            ':mensaje' => $mensaje,
            ':fecha' => $fechaEnvio
        ]);
        
        header("Location: ../contacto.html?status=success");
        exit();
    } catch (Exception $e) {
        header("Location: ../contacto.html?status=error");
        exit();
    }
}
?>