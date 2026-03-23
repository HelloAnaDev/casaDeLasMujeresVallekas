<?php 
include 'sidebarHeader.php'; 


require_once '../config/db.php';

$idMemoria = $_GET['id'] ?? null;

if (!is_numeric($idMemoria)) {
    echo "<script>window.location.href='memoriasAdmin.php';</script>";
    exit;
}

$sqlMemoria = "SELECT m.titulo, m.fecha, m.descripcion, a.nombre AS nombre_creadora 
               FROM memorias m 
               LEFT JOIN administradoras a ON m.id_admin = a.idAdmin 
               WHERE m.idMemoria = :id";
               
$stmt = $pdo->prepare($sqlMemoria);
$stmt->execute(['id' => $idMemoria]);
$memoria = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$memoria) {
    echo "<script>window.location.href='memoriasAdmin.php';</script>";
    exit;
}

$sqlFotos = "SELECT rutaImagen FROM imagenes_memorias WHERE idMemoria = :id";
$stmtFotos = $pdo->prepare($sqlFotos);
$stmtFotos->execute(['id' => $idMemoria]);
$fotos = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);

$fechaFormateada = date('d-m-Y', strtotime($memoria['fecha']));
$autora = $memoria['nombre_creadora'] ?? 'Casa de las Mujeres Vallekas';
?>

<main class="panelPrincipalAdmin">
    
    <a href="memoriasAdmin.php" class="btnVolver">
        <i class='bx bx-arrow-back'></i> Volver al listado
    </a>

    <article class="tarjetaDetalle">
        
        <header class="cabeceraDetalle">
            <h1 class="tituloDetalle"><?= htmlspecialchars($memoria['titulo']) ?></h1>
            <p class="metaDetalle">Publicado el: <?= $fechaFormateada ?> | Creado por: <?= htmlspecialchars($autora) ?></p>
        </header>

        <div class="contenidoDetalle">
            <p><?= nl2br(htmlspecialchars($memoria['descripcion'])) ?></p>
        </div>

        <div class="galeriaGrid">
            <?php 
            if (count($fotos) > 0) {
                foreach ($fotos as $foto) {
                    $rutaFinal = '../images/memorias/' . $foto['rutaImagen'];
                    echo "<img src='" . htmlspecialchars($rutaFinal) . "' alt='Imagen de la memoria'>";
                }
            } else {
                echo "<p style='color: #666; font-style: italic; text-align: center; grid-column: 1 / -1;'>Esta memoria no tiene imágenes asociadas.</p>";
            }
            ?>
        </div>

    </article>

</main>

</body>
</html>