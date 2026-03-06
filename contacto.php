<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de las mujeres Vallekas</title>
    <link rel="stylesheet" href="style.css">
    <!-- Fuentes obtenidas de Google Fonts, Poppins + Instrument serif -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Italianno&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>

<header class="cabecera">
    <a href="index.php"  id="contenedorLogoMovil">
        <img src="images/logoHorizontal.png" id="logoMovil" alt="Logotipo de la 'Casa de las Mujeres de Vallekas'. Tres mujeres diferentes, unidas, formando una casa con sus brazos.">
    </a>   

    <button id="btnMenu" class="menuToggle" aria-label="Abrir menú">☰</button>

    <nav id="menuLateral">
        <button id="btnOcultar" aria-label="Ocultar menú">✖ Ocultar menu</button>   
        <a href="index.php">Inicio</a>
        <a href="quienesSomos.php">Quiénes somos</a>
        <a href="agendaActividades.php">Agenda y actividades</a>
    
        <a href="index.php" id="contenedorLogo"><img src="images/logoHorizontal.png" id="logoHorizontal" alt="Logotipo de la 'Casa de las Mujeres de Vallekas'. Tres mujeres diferentes, unidas, formando una casa con sus brazos."></a>
    
        <a href="colabora.php">Colabora</a>
        <a class="seccionActual" href="contacto.php">Contacto</a>
        <a href="login.php" class="boton">Área privada</a>
    </nav> 
</header>
<main>
<div class="contenedorContacto">
    <div id="columnaIzquierdaRedes">
        <ul>
            <li><a href="https://www.instagram.com/casademujeresvk/" rel="noopener noreferrer" target="_blank">Instagram</a></li>
            <li><a href="https://www.facebook.com/p/Casa-de-las-Mujeres-de-Vallekas-100067144956203/?locale=es_LA" rel="noopener noreferrer" target="_blank">Facebook</a></li>
            <li>653 53 92 12 | <a href="tel:+34653539212">Teléfono</a> | <a href="https://wa.me/34653539212"></a>Whatsapp</a></li>
            <li><a href="mailto:casademujeresvk@gmail.com">casademujeresvk@gmail.com</a></li>
            <li><a href="https://maps.app.goo.gl/9rxrcuWJwi8xCzYb8" rel="noopener noreferrer" target="_blank">Calle Diligencia, 10 (entrada por calle Volver a Empezar) 28038, Puente de Vallecas. Madrid.</a></li>
        </ul>
    </div>

    <div id="columnaDerechaFormularioContacto">
        <div id="mensajeNotificacion" class="oculto"></div>
        <form action="backend/procesarContacto.php" method="post" class="formularioMensaje">
            <label for="nombre">Nombre y apellidos</label>
            <input name="nombre" type="text" id="nombre" placeholder="María García Romero">

            <fieldset class="grupoRadios">
                <legend>¿A través de que medio prefieres que nos pongamos en contacto contigo?</legend>

                <div class="opcionRadio">
                    <input type="radio" id="medioWhatsapp" name="medioPreferido" value="whatsapp" checked>
                    <label for="medioWhatsapp">WhatsApp</label>
                </div>

                <div class="opcionRadio">
                    <input type="radio" id="medioLlamada" name="medioPreferido" value="llamada">
                    <label for="medioLlamada">Llamada telefónica <span>(Si marcas esta opción, ¡recuerda que te aparecerá la llamada desde un número desconocido!)</span> 
                    </label>
                </div>
                
                <div class="opcionRadio">
                    <input type="radio" id="medioEmail" name="medioPreferido" value="email">
                    <label for="medioEmail">Correo electrónico</label>
                </div>                
            </fieldset>

            <p id="notaContacto">No estás obligada a rellenar todos los campos de contacto, sin embargo, ¡recuerda poner tu medio preferido para que te podamos hacer llegar la respuesta a tu consulta!</p>

            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com">

            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" placeholder="600 000 000">

            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" id="mensaje" placeholder="Buenos días, os escribo porque..." required></textarea>

            <div class="checkbox">
                <input type="checkbox" id="politica" name="politica" required>
                <label for="politica" class="labelInline">He leído y acepto <a href="legal.php">la política de privacidad</a>.<br>En resumen, esta política significa que no vamos a compartir tus datos con nadie, ni utilizarlos con otro fin más que resolver tu consulta. ¡Puedes estar tranquila!.</label>
            </div>
    <div class="campoOculto" aria-hidden="true">
    <label for="sitioWeb">Campo de verificación para no humanos.</label>
    <input type="text" id="sitioWeb" name="sitioWeb" tabindex="-1" autocomplete="off">
</div>
            <button type="submit" class="btnEnvio">Enviar mensaje</button>
        </form>    
    </div>
</div>
</main>

<footer class="piePagina">
    <div class="pieColumnas">
        
        <div class="columnaLogo">
            <a href="index.php">
                <img src="images/logoVector.png" alt="Logotipo de la Casa de las Mujeres de Vallekas">
            </a>
        </div>

        <div class="columnaEnlaces">
            <span class="tituloPie">SÍGUENOS</span>
            <ul>
                <li><a href="https://www.instagram.com/casademujeresvk/" rel="noopener noreferrer" target="_blank">Instagram</a></li>
                <li><a href="https://www.facebook.com/p/Casa-de-las-Mujeres-de-Vallekas-100067144956203/?locale=es_LA" rel="noopener noreferrer" target="_blank">Facebook</a></li>
            </ul>
        </div>

        <div class="columnaEnlaces">
            <span class="tituloPie">CONTACTO</span>
            <ul>
                <li><a href="https://wa.me/34653539212">653 53 92 12</a></li>
                <li><a href="mailto:casademujeresvk@gmail.com">casademujeresvk@gmail.com</a></li>
            </ul>
            <span class="tituloPie espaciadoExtra">ENCUENTRANOS EN</span>
            <ul>  
                <li><a href="https://maps.app.goo.gl/9rxrcuWJwi8xCzYb8" rel="noopener noreferrer" target="_blank">Calle Diligencia, 10 (entrada por calle Volver a Empezar) <br> 28038, Puente de Vallecas. Madrid.</a></li>
            </ul>
        </div>
        <div class="columnaEnlaces">
            <ul>
                <li><a href="legal.php">Aviso legal</a></li>                
                <li><a href="legal.php">Política de Privacidad</a></li>
                <li><a href="legal.php">Política de cookies</a></li>
                <li><a href="legal.php">Términos y condiciones</a></li>
            </ul>
        </div>
    </div>

    <div class="pieCreditos">
        <p>2026 &copy; Casa de las Mujeres Vallekas</p>
        <p>Desarrollado por <a href="#" target="_blank" rel="noopener noreferrer">Hello.ana.dev</a></p>
    </div>
</footer>
<script src="interaccion.js"></script>
</body>
</html>