<?php 
require_once 'config/config.php';
require_once 'config/db.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: casaEnMarcha.php");
    exit;
}

$idMemoria = $_GET['id'];

try {
    $sql = "SELECT m.*, GROUP_CONCAT(i.rutaImagen) AS galeria 
            FROM memorias m 
            LEFT JOIN imagenes_memorias i ON m.idMemoria = i.idMemoria 
            WHERE m.idMemoria = ?";
            
    if (!isset($_SESSION['idAdmin'])) {
        $sql .= " AND m.es_borrador = 0";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idMemoria]);
    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$noticia || empty($noticia['titulo'])) {
        header("Location: casaEnMarcha.php");
        exit;
    }

    $sqlCom = "SELECT nombre, texto, fecha FROM comentarios WHERE idMemoria = ? AND estadoPublicacion = 1 ORDER BY fecha DESC";
    $stmtCom = $pdo->prepare($sqlCom);
    $stmtCom->execute([$idMemoria]);
    $comentarios = $stmtCom->fetchAll(PDO::FETCH_ASSOC);

    $fotos = $noticia['galeria'] ? explode(',', $noticia['galeria']) : [];
    $fotoPrincipal = count($fotos) > 0 ? "images/memorias/" . $fotos[0] : "images/paisaje.png";
    $categoria = $noticia['categoria'] ?? 'LA CASA';
    $likes = $noticia['likes'] ?? 0;

    $fotosJSON = json_encode($fotos);

    $og_title = htmlspecialchars($noticia['titulo']);
    $og_desc = htmlspecialchars(mb_substr($noticia['descripcion'], 0, 150)) . '...';
    $og_image = "https://" . $_SERVER['HTTP_HOST'] . BASE_URL . "/" . $fotoPrincipal;

} catch (PDOException $e) {
    die("Error cargando la lectura.");
}

$pagina = 'casaEnMarcha';
include 'header.php'; 
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
                <div class="controles-vista-fotos">
                    <span class="etiqueta-vista">Ver individualmente</span>
                    <label class="switch-vista">
                        <input type="checkbox" id="toggleVistaFotos" checked>
                        <span class="slider-vista round"></span>
                    </label>
                    <span class="etiqueta-vista">Ver todas las fotos apiladas</span>
                </div>
                
                <p class="ayuda-swipe" id="ayudaSwipeFotos" style="display: none;">Desliza a los lados para ver las demás fotos</p>
                
                <div class="contenedor-galeria-dinamica modo-apilado" id="galeriaDinamica">
                    <?php foreach ($fotos as $f): ?>
                        <img class="foto-galeria" src="images/memorias/<?= $f ?>" alt="Fotografía de la actividad">
                    <?php endforeach; ?>
                </div>
                
                <div class="indicadores-swipe" id="indicadoresSwipe" style="display: none;">
                    <?php foreach ($fotos as $idx => $f): ?>
                        <span class="punto-swipe <?= $idx === 0 ? 'activo' : '' ?>"></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="barra-interaccion">
                <button class="btn-like-lectura" id="btnLikeLectura" data-id="<?= $idMemoria ?>">
                    <svg viewBox="0 0 24 24" class="icono-corazon-lectura"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    <span id="contadorLikesLectura"><?= $likes ?></span> me gusta
                </button>
                <button class="btn-compartir-icono" id="btnCompartirLectura" aria-label="Compartir esta entrada">
                    <svg viewBox="0 0 24 24" class="icono-avion-barra"><path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                </button>
            </div>

            <div class="texto-lectura">
                <?php
                    $textoSeguro = htmlspecialchars($noticia['descripcion']);
                    $textoConEnlaces = preg_replace('/(https?:\/\/[^\s<]+)/i', '<a href="$1" target="_blank" rel="noopener noreferrer" class="enlace-memoria">$1</a>', $textoSeguro);
                    $textoConEnlaces = preg_replace('/(?<!:\/\/)(www\.[^\s<]+)/i', '<a href="http://$1" target="_blank" rel="noopener noreferrer" class="enlace-memoria">$1</a>', $textoConEnlaces);
                ?>
                <p><?= nl2br($textoConEnlaces) ?></p>
            </div>

            <div class="tira-like-informativa">
                <div class="bloque-tira">
                    <span class="texto-tira-desktop">¿Te ha gustado esta publicación?<br>Para señalar que te ha gustado, haz clic en este corazón</span>
                    <span class="texto-tira-movil">¿Te ha gustado esta publicación?<br>Da un toque a este corazón</span>
                    <button class="btn-tira-like" id="btnTiraLike" aria-label="Dar me gusta">
                        <svg viewBox="0 0 24 24" class="icono-corazon-tira">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </button>
                </div>
                <div class="bloque-tira">
                    <span class="texto-tira-desktop">¿Quieres compartir por WhatsApp esta entrada con tus compañeras?<br>Haz clic en este avión</span>
                    <span class="texto-tira-movil">¿Quieres compartir por WhatsApp esta entrada con tus compañeras?<br>Toca este avión</span>
                    <button class="btn-tira-compartir" id="btnTiraCompartir" aria-label="Compartir esta entrada">
                        <svg viewBox="0 0 24 24" class="icono-avion-tira">
                            <path d="M22 2L11 13M22 2L15 22l-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <aside class="columna-comentarios">
            <div class="tablon-comentarios-sticky">
                
                <form id="formularioComentarios" class="formulario-comentarios">
                    <input type="hidden" id="idMemoriaActual" value="<?= $idMemoria ?>">

                    <div class="campoOculto" aria-hidden="true">
                        <label for="sitioWebComentario">No rellenar</label>
                        <input type="text" id="sitioWebComentario" name="sitioWebComentario" tabindex="-1" autocomplete="off">
                    </div>
                    
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
document.addEventListener("DOMContentLoaded", function() {
    
    // 1. LÓGICA DE PAGINACIÓN DE COMENTARIOS
    const comentariosDivs = document.querySelectorAll('.tarjeta-comentario');
    const porPagina = 4;
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

    // 2. LÓGICA DE ME GUSTA Y LOCALSTORAGE
    const idMemoria = document.getElementById('idMemoriaActual') ? document.getElementById('idMemoriaActual').value : null;
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

        // 3. LÓGICA BOTONES COMPARTIR
        const tituloEntrada = <?= json_encode($noticia['titulo']) ?>;
        const textoCompartir = `Una compañera piensa que te va a interesar "${tituloEntrada}" del blog de Casa de las Mujeres Vallekas, ¡Entra a verlo, disfruta, comenta y comparte!`;
        const urlCompartir = window.location.href;

        function accionCompartir() {
            const urlWhatsApp = `https://wa.me/?text=${encodeURIComponent(textoCompartir + ' ' + urlCompartir)}`;
            window.open(urlWhatsApp, '_blank');
        }

        const btnCompartirBarra = document.getElementById('btnCompartirLectura');
        const btnCompartirTira = document.getElementById('btnTiraCompartir');
        if (btnCompartirBarra) btnCompartirBarra.addEventListener('click', accionCompartir);
        if (btnCompartirTira) btnCompartirTira.addEventListener('click', accionCompartir);
    }

    // 4. LÓGICA DEL INTERRUPTOR DE FOTOS (Apilado / Swipe)
    const toggleVista = document.getElementById('toggleVistaFotos');
    const galeria = document.getElementById('galeriaDinamica');
    const ayudaSwipe = document.getElementById('ayudaSwipeFotos');
    const indicadores = document.getElementById('indicadoresSwipe');
    
    if (toggleVista && galeria) {
        toggleVista.addEventListener('change', (e) => {
            if (e.target.checked) {
                galeria.classList.remove('modo-carrusel');
                galeria.classList.add('modo-apilado');
                if(ayudaSwipe) ayudaSwipe.style.display = 'none';
                if(indicadores) indicadores.style.display = 'none';
            } else {
                galeria.classList.remove('modo-apilado');
                galeria.classList.add('modo-carrusel');
                if(ayudaSwipe) ayudaSwipe.style.display = 'block';
                if(indicadores) indicadores.style.display = 'block';
            }
        });

        galeria.addEventListener('scroll', () => {
            if(galeria.classList.contains('modo-carrusel') && indicadores) {
                const scrollLeft = galeria.scrollLeft;
                const width = galeria.offsetWidth;
                const index = Math.round(scrollLeft / width);
                const dots = indicadores.querySelectorAll('.punto-swipe');
                dots.forEach((dot, i) => {
                    dot.classList.toggle('activo', i === index);
                });
            }
        });
    }
});
</script>
</body>
</html>