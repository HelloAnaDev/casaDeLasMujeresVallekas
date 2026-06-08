<?php 
$pagina = 'casaEnMarcha';
include 'header.php'; 
require_once 'config/db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>window.location.href='casaEnMarcha.php';</script>";
    exit;
}

$idMemoria = $_GET['id'];

try {
    // 1. Obtener datos de la publicación
    $sql = "SELECT m.*, GROUP_CONCAT(i.rutaImagen) AS galeria 
            FROM memorias m 
            LEFT JOIN imagenes_memorias i ON m.idMemoria = i.idMemoria 
            WHERE m.idMemoria = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idMemoria]);
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$noticia || empty($noticia['titulo'])) {
        echo "<script>window.location.href='casaEnMarcha.php';</script>";
        exit;
    }

    // 2. Obtener comentarios aprobados
    $sqlCom = "SELECT nombre, texto, fecha FROM comentarios WHERE idMemoria = ? AND estadoPublicacion = 1 ORDER BY fecha DESC";
    $stmtCom = $pdo->prepare($sqlCom);
    $stmtCom->execute([$idMemoria]);
    $comentarios = $stmtCom->fetchAll(PDO::FETCH_ASSOC);

    // Preparar imágenes
    $fotos = $noticia['galeria'] ? explode(',', $noticia['galeria']) : [];
    $fotoPrincipal = count($fotos) > 0 ? "images/memorias/" . $fotos[0] : "images/paisaje.png";
    $categoria = $noticia['categoria'] ?? 'LA CASA';
    $likes = $noticia['likes'] ?? 0;

    // Pasamos las fotos a JSON para que JavaScript pueda hacer funcionar el carrusel
    $fotosJSON = json_encode($fotos);
    
} catch (PDOException $e) {
    die("Error cargando la lectura.");
}
?>

<main class="fondo-lectura">
    
    <div class="hero-lectura">
        <div class="hero-lectura-bg" style="background-image: url('<?= $fotoPrincipal ?>');"></div>
        <div class="hero-lectura-contenido">
            <span class="etiqueta-lectura"><?= $categoria ?></span>
            <h1><?= htmlspecialchars($noticia['titulo']) ?></h1>
        </div>
    </div>

    <div class="contenedor-volver">
        <a href="casaEnMarcha.php" class="btn-volver-muro">
            <span>◀</span> Volver al muro de publicaciones
        </a>
    </div>

    <div class="layout-dos-columnas-lectura">
        
        <section class="columna-contenido">
            
            <?php if (count($fotos) > 0): ?>
            <div class="carrusel-lectura">
                <button id="btnAnteriorLectura" class="flecha-carrusel-lectura">◀</button>
                
                <div class="contenedor-fotos-lectura">
                    <img id="fotoCentroLectura" class="foto-central-lectura" src="<?= $fotoPrincipal ?>" alt="Fotografía de la actividad">
                </div>
                
                <button id="btnSiguienteLectura" class="flecha-carrusel-lectura">▶</button>
            </div>
            <p id="contadorCarruselLectura" class="contador-carrusel">1 / <?= count($fotos) ?></p>
            <?php endif; ?>

            <div class="barra-interaccion">
                <button class="btn-like-lectura" id="btnLikeLectura" data-id="<?= $idMemoria ?>">
                    <svg viewBox="0 0 24 24" class="icono-corazon-lectura"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <span id="contadorLikesLectura"><?= $likes ?></span> me gusta
                </button>
            </div>

            <div class="texto-lectura">
                <p><?= nl2br(htmlspecialchars($noticia['descripcion'])) ?></p>
            </div>
        </section>

        <aside class="columna-comentarios">
            <div class="tablon-comentarios-sticky">
                
                <form id="formComentarioLectura" class="formulario-comentarios">
                    <input type="hidden" id="idMemoriaComentario" value="<?= $idMemoria ?>">
                    
                    <label for="aliasNuevo">Nombre / Alias</label>
                    <input type="text" id="aliasNuevo" required>
                    
                    <label for="textoNuevo">Comentario</label>
                    <textarea id="textoNuevo" required></textarea>
                    
                    <button type="submit" class="btn-enviar-comentario">ENVIAR</button>
                </form>

                <div class="lista-comentarios">
                    <?php if (count($comentarios) > 0): ?>
                        <?php foreach ($comentarios as $com): ?>
                            <div class="tarjeta-comentario">
                                <h4><?= htmlspecialchars($com['nombre']) ?> <span><?= date('d/m/Y', strtotime($com['fecha'])) ?></span></h4>
                                <p><?= nl2br(htmlspecialchars($com['texto'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="comentario-vacio-animador">
                            <p>Aún no hay comentarios, ¡Anímate a ser la primera en compartir tus impresiones!</p>
                        </div>
                    <?php endif; ?>
                </div>
                
            </div>
        </aside>

    </div>
</main>

<?php include 'footer.php'; ?>

<script>
    const listaFotos = <?= $fotosJSON ?>;
</script>
<script src="lectura.js?v=1"></script>

</body>
</html>