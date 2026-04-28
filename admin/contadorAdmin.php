<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

require_once '../config/config.php';

$mensajeExito = '';
$mensajeError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrar_id'])) {
    $id_borrar = $_POST['borrar_id'];
    try {
        $sqlDelete = "DELETE FROM registro_feminicidios WHERE id = :id";
        $stmtDelete = $pdo->prepare($sqlDelete);
        if ($stmtDelete->execute(['id' => $id_borrar])) {
            $mensajeExito = "Registro eliminado correctamente.";
        } else {
            $mensajeError = "Error al intentar eliminar el registro.";
        }
    } catch (PDOException $e) {
        $mensajeError = "Error interno de base de datos.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['visibilizar'])) {
    $tipo_victima = $_POST['edad_victima']; 
    $nombre = trim($_POST['nombre']); 
    $fecha_registro = $_POST['fecha_registro'];
    
    if (empty($nombre) || $tipo_victima === 'menor') {
        $nombre = null;
    }

    try {
        $sqlInsert = "INSERT INTO registro_feminicidios (nombre, fecha_registro, tipo_victima, fecha_creacion) VALUES (:nombre, :fecha_registro, :tipo, NOW())";
        $stmtInsert = $pdo->prepare($sqlInsert);
        
        if ($stmtInsert->execute(['nombre' => $nombre, 'fecha_registro' => $fecha_registro, 'tipo' => $tipo_victima])) {
            $mensajeExito = "Contador actualizado y memoria registrada con éxito.";
        } else {
            $mensajeError = "Error al intentar registrar el dato.";
        }
    } catch (PDOException $e) {
        $mensajeError = "Error interno de base de datos.";
    }
}

$registros = [];
try {
    $sqlSelect = "SELECT * FROM registro_feminicidios ORDER BY fecha_registro DESC";
    $stmtSelect = $pdo->query($sqlSelect);
    $registros = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensajeError = "Error al cargar los registros.";
}

$pagina = 'adminContador'; 
include 'sidebarHeader.php';
?>

<div class="contenedorContadorAdmin">
    <p class="textoIntro">Este área está dedicado a la actualización del contador público de días libres de feminicidios. Si ha tenido lugar un asesinato por violencia de género, escribe los siguientes datos sobre la víctima y pulsa el botón "visibilizar" para reiniciar el contador y denunciar esta situación que sufrimos diariamente las mujeres.</p>

    <?php if ($mensajeExito): ?>
        <div class="alerta exito"><?php echo htmlspecialchars($mensajeExito); ?></div>
    <?php endif; ?>
    <?php if ($mensajeError): ?>
        <div class="alerta error"><?php echo htmlspecialchars($mensajeError); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        
        <div class="grupoFormulario">
            <p class="textoInstruccion">Selecciona la fecha en la que tuvo lugar:</p>
            <div class="inputEnLinea">
                <label for="fecha_registro">Fecha :</label>
                <input type="date" id="fecha_registro" name="fecha_registro" class="inputSubrayado" required>
            </div>
        </div>

        <div class="grupoFormulario">
            <p class="textoInstruccion">Para honrar su memoria, escribe su nombre si las fuentes oficiales lo han hecho público. Si no se ha hecho público o es menor de edad, deja este campo en blanco.</p>
            <div class="inputEnLinea">
                <label for="nombre">Nombre :</label>
                <input type="text" id="nombre" name="nombre" class="inputSubrayado">
            </div>
        </div>

        <div class="grupoFormulario">
            <p class="textoInstruccion">Indica respecto a la edad de la víctima si es:</p>
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
            <p class="textoInstruccion">Revisa los datos escritos arriba y marca la siguiente casilla:</p>
            <label class="checkboxLabel">
                <input type="checkbox" name="confirmacion" required>
                <span class="checkboxTexto">He revisado los datos escritos anteriormente.</span>
            </label>
        </div>

        <div class="contenedorBoton">
            <button type="submit" name="visibilizar" class="btnVisibilizar">
                <div class="iconoLazo">Publicar y visibilizar</div> 
            </button>
        </div>
    </form>

    <div class="panelGestion">
            <p>Desde esta sección pueden borrarse duplicados en caso de necesitarlo (si por ejemplo, si dos compañeras han creado dos veces por error el mismo registro). Si este no es el caso, no debe borrarse ningún dato y no es necesario usar la siguiente tabla.</p>
            <p>Si necesitas borrar, busca el caso y dale al botón rojo "Borrar". Para evitar equivocaciones, te saldrá un mensaje preguntándote de nuevo si quieres borrar los datos. Si es así, dale a aceptar, si te has equivocado, dale a cancelar.</p>
    <details>
        <summary class="tituloGestion">Registros (Mostrar/Ocultar)</summary>
            <table class="tablaRegistros">
                <thead>
                    <tr>
                        <th>Fecha Caso</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($registros)): ?>
                        <tr><td colspan="4" style="text-align:center;">No hay registros.</td></tr>
                    <?php else: ?>
                        <?php foreach ($registros as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['fecha_registro']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre'] ?? 'Anónimo / Menor'); ?></td>
                            <td><?php echo htmlspecialchars($row['tipo_victima'] ?? 'No definido'); ?></td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('¿Borrar registro?');" style="margin: 0;">
                                    <input type="hidden" name="borrar_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btnBorrarRegistro">Borrar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </details>
    </div>
</div>