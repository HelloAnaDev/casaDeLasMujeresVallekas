<?php 
$pagina = 'index';
include 'header.php'; 
?>
    
<div class="bannerPortada">
    <div class="textoBanner">
    <h1 class="frase">Si sobreviví, fue gracias a la red que tejí.</h1>
    </div>
</div>

 <div class="tarjetaInformacion">
    <p>Este es un espacio abierto y gestionado por y para las mujeres del barrio. La Casa de las Mujeres de Vallekas nace como un punto de encuentro, apoyo mutuo y resistencia. Construimos una red donde la diversidad, el feminismo y la solidaridad vecinal son nuestros pilares.</p>
<p>En Vallekas, ninguna mujer camina sola. <strong>Pasa, ponte cómoda: esta también es tu casa.</strong> </p>
</div>
<div class="contenedor-carrusel-hacemos">
    <button class="flecha-carrusel prev" id="btnAtras" aria-label="Anterior"></button>
    <button class="flecha-carrusel next" id="btnSig" aria-label="Siguiente"></button>

    <div class="divTitulo" id="carruselHacemos">
        <div class="tarjetasHacemos" id="tarjetaA">
            <h3 class="tituloHacemos">Acogedoras</h3>
            <img src="<?php echo BASE_URL; ?>/images/iconos/acogedoras.png" alt="Icono acogedoras">
            <p>Ayudamos, acompañamos y apoyamos a cualquier mujer que lo necesite.</p>
        </div>
        
        <div class="tarjetasHacemos" id="tarjetaB">
            <h3 class="tituloHacemos">Activismo</h3>
            <img src="<?php echo BASE_URL; ?>/images/iconos/activismo.png" alt="Icono activismo">
            <p>Participamos activamente en los movimientos justos y reivindicativos.</p>
        </div>

        <div class="tarjetasHacemos" id="tarjetaC">
            <h3 class="tituloHacemos">Actividades</h3>
            <img src="<?php echo BASE_URL; ?>/images/iconos/actividades.png" alt="Icono actividades">
            <p>Talleres, charlas y actividades para nuestro empoderamiento.</p>
        </div>
    </div>
</div>

<h2 id="tituloDeCalendario" >Calendario</h2>

 <div class="tarjetaInformacion">
    <p>Nuestro calendario subraya los aniversarios e hitos históricos protagonizados por mujeres que, pese a su relevancia, han sido invisibilizados. ¡Echa un vistazo y recupera nuestra historia!</p>
 </div> 
<div id="detalleHito" class="detalle-oculto">
    <h4 id="tituloDetalle">Lo que no se nombra, no existe. Aquí les devolvemos su nombre.</h4>
    <p id="cuerpoDetalle">Haz click en un día destacado para conocer su historia.</p>
</div>
 <!-- CALENDARIO -->

 <section id="calendario">
    <header class="controlesCalendario">
        <button id="btnAnterior">Anterior</button>

        <h3 id="fechaActual"></h3>

        <button id="btnSiguiente">Siguiente</button>
    </header>

    <div class="filtrarCalendario">
        <label for="filtroCategoria">Filtrar por: </label>
        <select id="filtroCategoria">
            <option value="todas">Todas</option>
            <option value="inventos">Inventos</option>
            <option value="revolucion">Revolución</option>
            <option value="aniversarios">Aniversarios</option>
        </select> </div>
    <div class="cabeceraDias">
    <div>L</div>
    <div>M</div>
    <div>M</div>
    <div>J</div>
    <div>V</div>
    <div>S</div>
    <div>D</div>
</div>

    <div id="cuadriculaCalendario" class="cuadricula"></div>
    <br><p>¿Te gusta lo que ves? Te invitamos a seguir conociéndonos a través de esta página web en la que estás navegando ahora, nuestras redes sociales, y sobre todo, en nuestra casa en Vallekas, <strong>¡Aquí cabemos todas!</strong></p>
 </section>


<?php include 'footer.php'; ?>

</body>
</html>