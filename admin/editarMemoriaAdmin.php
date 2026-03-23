<?php 
include 'sidebarHeader.php'; 
require_once '../config/db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) { header("Location: memoriasAdmin.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM memorias WHERE idMemoria = ?");
$stmt->execute([$id]);
$memoria = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$memoria) { die("Memoria no encontrada"); }
?>

<main class="panelPrincipalAdmin">
    <a href="memoriasAdmin.php" class="btnVolver"><i class='bx bx-arrow-back'></i> Cancelar edición</a>

    <section class="contenedorFormulario">
        <h1 class="tituloSeccion">Editar: <?= htmlspecialchars($memoria['titulo']) ?></h1>
        
        <form action="procesarEditar.php" method="POST" enctype="multipart/form-data" class="formularioAdmin">
            
            <input type="hidden" name="idMemoria" value="<?= $memoria['idMemoria'] ?>">

            <div class="grupoInput">
                <label>Título / Mes</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($memoria['titulo']) ?>" required>
            </div>

            <div class="grupoInput">
                <label>Fecha de la actividad</label>
                <input type="date" name="fecha" value="<?= date('Y-m-d', strtotime($memoria['fecha'])) ?>" required>
            </div>

            <div class="grupoInput">
                <label>Descripción detallada</label>
                <textarea name="descripcion" rows="8" required><?= htmlspecialchars($memoria['descripcion']) ?></textarea>
            </div>

            <div class="grupoInput">
                <label for="fotos">¿Quieres añadir más fotos a esta memoria?</label>
                <input type="file" id="fotosNuevas" name="imagenes[]" accept="image/*" multiple class="inputFileCustom">
                
                <div id="contenedorPrevisualizacion" class="galeriaEdicion"></div>
                
                <p class="ayudaInput">Puedes seleccionar varios archivos a la vez.</p>
            </div>

            <div class="grupoInput">
                <label>Fotos actuales (Haz clic en la papelera para eliminar)</label>
                <div class="galeriaEdicion">
                    <?php
                    $stmtFotos = $pdo->prepare("SELECT * FROM imagenes_memorias WHERE idMemoria = ?");
                    $stmtFotos->execute([$id]);
                    $fotosExistentes = $stmtFotos->fetchAll();

        foreach ($fotosExistentes as $foto): 
            $ruta = "../images/memorias/" . $foto['rutaImagen'];
        ?>
            <div class="fotoEditable">
                <img src="<?= $ruta ?>" alt="Foto memoria">
                <a href="borrarFotos.php?idImg=<?= $foto['idImagen'] ?>&idMem=<?= $id ?>" 
                   class="btnEliminarFoto" 
                   onclick="return confirm('¿Eliminar esta imagen permanentemente?')">
                    <i class='bx bx-trash'></i>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

            <div class="accionesForm">
                <button type="submit" class="btnGuardar">
                    <i class='bx bx-save'></i> Guardar cambios
                </button>
            </div>
        </form>
    </section>
    
</main>
<script>
document.getElementById('fotosNuevas').addEventListener('change', function(event) {
    const contenedor = document.getElementById('contenedorPrevisualizacion');
    contenedor.innerHTML = ''; 

    const archivos = event.target.files;

    for (const archivo of archivos) {
        const lector = new FileReader();

        lector.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            contenedor.appendChild(img);
        }

        lector.readAsDataURL(archivo);
    }
});
</script>