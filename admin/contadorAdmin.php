<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../config/config.php';

$mensajeExito = '';
$mensajeError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['visibilizar'])) {
    
    $tipo_victima = $_POST['edad_victima']; 
    $nombre = trim($_POST['nombre']); 
    
    if (empty($nombre)) {
        $nombre = null;
    }

    if ($tipo_victima === 'menor') {
        $nombre = null;
    }

    try {
        $sql = "INSERT INTO registro_feminicidios (nombre, fecha_registro, tipo_victima) VALUES (:nombre, CURDATE(), :tipo)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute(['nombre' => $nombre, 'tipo' => $tipo_victima])) {
            $mensajeExito = "Contador actualizado y memoria registrada con éxito.";
        } else {
            $mensajeError = "Error al intentar registrar el dato en la base de datos.";
        }
    } catch (PDOException $e) {
        $mensajeError = "Error interno de base de datos.";
    }
}

$pagina = 'adminContador'; 
include 'sidebarHeader.php';
?>


<div class="contenedorContadorAdmin">
    <p class="textoIntro">Este área está dedicado a la actualización del contador público de días libres de feminicidios. Si ha tenido lugar un asesinato por violencia de género, escribe los siguientes datos sobre la víctima y pulsa el botón "visibilizar" para reiniciar el contador y denunciar esta situación que sufrimos diariamente las mujeres.</p>

    <?php if ($mensajeExito): ?>
        <div class="alerta exito"><?php echo $mensajeExito; ?></div>
    <?php endif; ?>
    <?php if ($mensajeError): ?>
        <div class="alerta error"><?php echo $mensajeError; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        
        <div class="grupoFormulario">
            <p class="textoInstruccion">Para honrar su memoria, escribe su nombre si las fuentes oficiales lo han hecho público. Si no se ha hecho público para proteger su intimidad o la de su familia, deja este campo en blanco.</p>
            <div class="inputEnLinea">
                <label for="nombre">Nombre :</label>
                <input type="text" id="nombre" name="nombre" class="inputSubrayado">
            </div>
        </div>

        <div class="grupoFormulario">
            <p class="textoInstruccion">Para diferenciar a las mujeres mayores de edad de las niñas, por favor, indica respecto a la edad de la víctima si es:</p>
            <div class="opcionesRadio">
                <label class="radioLabel">
                    <input type="radio" name="edad_victima" value="mayor" required> 
                    <span class="radioTexto">Mayor de edad (18 años o más)</span>
                </label>
                <label class="radioLabel">
                    <input type="radio" name="edad_victima" value="menor" required> 
                    <span class="radioTexto">Menor de edad (Sin cumplir los 18)</span>
                </label>
            </div>
        </div>

        <div class="grupoFormulario">
            <p class="textoInstruccion">Revisa los datos escritos arriba y marca la siguiente casilla</p>
            <label class="checkboxLabel">
                <input type="checkbox" name="confirmacion" required>
                <span class="checkboxTexto">He revisado los datos escritos anteriormente</span>
            </label>
        </div>

        <div class="contenedorBoton">
            <button type="submit" name="visibilizar" class="btnVisibilizar">
                <div class="iconoLazo">Publicar y visibilizar</div> 
                
            </button>
        </div>

    </form>
</div>

</body>
</html>