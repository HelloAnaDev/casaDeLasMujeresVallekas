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

<!-- SECCIÓN CONOCER Y PARTICIPAR EN LA CASA EN MARCHA -->
 <<h2 class="tituloSeccion">La Casa está en marcha</h2>

  <div class="tarjetaInformacion">
    <p> <strong>¡Estamos en marcha!</strong> <span class="subrayado">Conoce qué hacemos</span> en la casa, de qué hablamos, qué nos importa... Estas invitada a nuestro blog dónde contamos tanto nuestras actividades y actos más representativos cómo los que pueden pasar más desapercibidos pero sabemos qué importan, y que por eso, queremos dejarlo en nuestra página para tenerlo siempre presente. En este espacio <span class="subrayado">puedes leernos</span>, <span class="subrayado">comentar qué opinas</span>, dar <span class="subrayado">"me gusta"</span> y <span class="subrayado">compartir</span> las entradas que quieras con otras compañeras tuyas que quizás no nos conzcan. ¡Entra a echar un ojo!</p>

    <p>Además, <span class="subrayado">envíanos</span> entradas <span class="subrayado">escritas por ti</span> relacionadas con el feminismo, las mujeres o cualquier otro contenido que consideres importante de compartir con todas. Incluso, <span class="subrayado">si tienes la idea</span> pero prefieres seguir <span class="subrayado">como lectora</span>, dínoslo e investigaremos para crear una entrada que sea de tu interés, ¡y del de muchas más seguro!.</p> 
    <p>Si tienes algo que decir o que te gustaría leer aquí en <a id="enlaceIndex" href="https://helloanadev.alwaysdata.net/casaEnMarcha.php"> La casa en Marcha</a>, escríbenos por <a id="enlaceIndex"
    href="mailto:casademujeresvk@gmail.com">email</a> con tu idea o tu texto, aporta tus imágenes si quieres, y el contenido una vez moderado por nuestras administradoras será visible para todas. <span class="subrayado"> Porque la casa,</span> <span class="subrayado">la construimos todas.</span></p>
    </div>
    <div class="casaMarchaGrid">

    <div class="casaMarchaItem">
        <img src="images/casaEnMarchaIndex/icono1.webp" alt="">
        <p><strong>Conoce</strong></p><p>qué hacemos en la Casa, nuestras movilizaciones, actividades, pensamientos....</p>
    </div>

    <div class="casaMarchaItem">
        <img src="images/casaEnMarchaIndex/icono2.webp" alt="">
        <p><strong>Participa</strong></p><p>Lee, comenta con tus ideas y experiencias, y comparte.</p>
    </div>

    <div class="casaMarchaItem">
        <img src="images/casaEnMarchaIndex/icono3.webp" alt="">
        <p><strong>Construimos</strong></p><p>Un espacio abierto para todas, escribe tu aportación o qué te gustaría leer.</p>
    </div>
</div>
<div class="contenedorBoton">
<a href="https://helloanadev.alwaysdata.net/casaEnMarcha.php" class="btnAccederCasa">
    Entra aquí a la Casa en marcha para conocerlo todo
</a></div>
<!-- SECCIÓN CALENDARIO -->
<h2 class="tituloSeccion">Calendario</h2>

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