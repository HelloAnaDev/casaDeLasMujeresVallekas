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
    
    <div class="contenedor-volver" style="padding-top: 20px;">
        <a href="casaEnMarcha.php" class="btn-volver-muro">
            <span>◀</span> Volver al muro de publicaciones
        </a>
    </div>

    <div class="hero-lectura">
        <div class="hero-lectura-bg" style="background-image: url('<?= $fotoPrincipal ?>');"></div>
        <div class="hero-lectura-contenido">
            <span class="etiqueta-lectura"><?= $categoria ?></span>
            <h1><?= htmlspecialchars($noticia['titulo']) ?></h1>
        </div>
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

            <div class="tira-like-informativa">
                <span class="texto-tira-desktop">¿Te ha gustado esta publicación?<br>Para señalar que te ha gustado, haz clic en este corazón</span>
                <span class="texto-tira-movil">¿Te ha gustado esta publicación?<br>Para señalar que te ha gustado, da un toque a este corazón</span>
                
                <button class="btn-tira-like" id="btnTiraLike" aria-label="Dar me gusta">
                    <svg viewBox="0 0 24 24" class="icono-corazon-tira">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                </button>
            </div>
        </section>

        <aside class="columna-comentarios">
            <div class="tablon-comentarios-sticky">
                
                <form id="formularioComentarios" class="formulario-comentarios">
                    <input type="hidden" id="idMemoriaActual" value="<?= $idMemoria ?>">
                    
                    <label for="aliasComentario">Nombre / Alias</label>
                    <input type="text" id="aliasComentario" required>
                    
                    <label for="textoComentario">Comentario</label>
                    <textarea id="textoComentario" required></textarea>
                    
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
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. LÓGICA DE PAGINACIÓN DE COMENTARIOS
    const comentariosDivs = document.querySelectorAll('.tarjeta-comentario');
    const porPagina = 4; // Cambia este número si quieres más o menos por página
    let paginaActual = 1;
    
    if (comentariosDivs.length > porPagina) {
        const contenedorLista = document.querySelector('.lista-comentarios');
        
        const divPaginacion = document.createElement('div');
        divPaginacion.className = 'paginacion-comentarios';
        
        const btnAnterior = document.createElement('button');
        btnAnterior.className = 'btn-paginacion';
        btnAnterior.innerText = '◀ Anterior';
        
        const btnSiguiente = document.createElement('button');
        btnSiguiente.className = 'btn-paginacion';
        btnSiguiente.innerText = 'Siguiente ▶';
        
        divPaginacion.appendChild(btnAnterior);
        divPaginacion.appendChild(btnSiguiente);
        contenedorLista.parentElement.appendChild(divPaginacion);
        
        function mostrarPagina(pagina) {
            const inicio = (pagina - 1) * porPagina;
            const fin = inicio + porPagina;
            
            comentariosDivs.forEach((com, index) => {
                com.style.display = (index >= inicio && index < fin) ? 'block' : 'none';
            });
            
            btnAnterior.disabled = pagina === 1;
            btnSiguiente.disabled = fin >= comentariosDivs.length;
        }
        
        btnAnterior.addEventListener('click', (e) => {
            e.preventDefault();
            if (paginaActual > 1) {
                paginaActual--;
                mostrarPagina(paginaActual);
            }
        });
        
        btnSiguiente.addEventListener('click', (e) => {
            e.preventDefault();
            if ((paginaActual * porPagina) < comentariosDivs.length) {
                paginaActual++;
                mostrarPagina(paginaActual);
            }
        });
        
        mostrarPagina(1);
    }

    // 2. LÓGICA DE ME GUSTA Y LOCALSTORAGE (Botón debajo de fotos y Botón de la nueva Tira)
    const idMemoria = document.getElementById('idMemoriaComentario') ? document.getElementById('idMemoriaComentario').value : null;
    const btnLike = document.getElementById('btnLikeLectura');
    const btnTiraLike = document.getElementById('btnTiraLike');
    const contadores = document.querySelectorAll('#contadorLikesLectura');

    if (idMemoria) {
        let likesLocales = JSON.parse(localStorage.getItem('likes_dispositivo')) || [];
        let yaDioLike = likesLocales.includes(idMemoria);

        function actualizarEstadoVisual() {
            if (yaDioLike) {
                if (btnLike) btnLike.classList.add('like-activo');
                if (btnTiraLike) btnTiraLike.classList.add('like-activo');
            } else {
                if (btnLike) btnLike.classList.remove('like-activo');
                if (btnTiraLike) btnTiraLike.classList.remove('like-activo');
            }
        }

        actualizarEstadoVisual();

        function procesarLike(evento) {
            evento.preventDefault();
            let accion = yaDioLike ? 'unlike' : 'like';

            fetch('sumar_like.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: idMemoria, accion: accion })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    contadores.forEach(c => c.textContent = data.likes);
                    if (accion === 'like') {
                        yaDioLike = true;
                        likesLocales.push(idMemoria);
                    } else {
                        yaDioLike = false;
                        likesLocales = likesLocales.filter(id => id !== idMemoria);
                    }
                    localStorage.setItem('likes_dispositivo', JSON.stringify(likesLocales));
                    actualizarEstadoVisual();
                }
            })
            .catch(err => console.error('Error con el like:', err));
        }

        if (btnLike) btnLike.addEventListener('click', procesarLike);
        if (btnTiraLike) btnTiraLike.addEventListener('click', procesarLike);
    }
});
</script>
</body>
</html>