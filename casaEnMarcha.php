<?php 
$pagina = 'agendaActividades';
include 'header.php'; 
?>

<main>
    <div id="pantallaMemoria" class="layoutDosColumnas">
        
        <section id="columnaIzquierda" class="detalleMemoria">
            <div class="navegacionMeses">
                <button id="btnMesAnterior">⬅</button>
                <h2 id="tituloMes">Cargando...</h2>
                <button id="btnMesSiguiente">🠪</button>
            </div>

            <div class="carrusel">
                <button id="btnFotoAnterior" class="flechaCarrusel">◀</button>

                <div class="contenedorFotos">
                    <img id="fotoAnterior" class="fotoLateral">
                    <img id="fotoPrincipal" class="fotoCentral">
                    <img id="fotoSiguiente" class="fotoLateral">
                </div>
                
                <button id="btnFotoSiguiente" class="flechaCarrusel">▶</button>
            </div>

            <p id="contadorFotos">0/0</p>
            <p id="textoMemoria"></p>
        </section>

        <aside id="columnaDerecha" class="panelComentarios">
            <form id="formularioComentarios">
                <label>Nombre / Alias</label>
                <input type="text" id="aliasComentario" required>
                
                <label>Comentario</label>
                <textarea id="textoComentario" required></textarea>
                
                <button type="submit">ENVIAR</button>
            </form>

            <div id="muroComentarios">
                <div class="comentarioVacio">
                    <p>Aún no hay comentarios, ¡Anímate a compartir tus impresiones!</p>
                </div>
            </div>
        </aside>

    </div> </main>
<?php include 'footer.php'; ?>

<script src="memorias.js"></script>

<script src="interaccion.js"></script>
</body>
</html>