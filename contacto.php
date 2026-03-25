<?php 
$pagina = 'contacto';
include 'header.php';
?>

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

            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="ejemplo@correo.com">

            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" placeholder="600 000 000">

            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" id="mensaje" placeholder="Buenos días, os escribo porque..." required></textarea>

            <div class="checkbox">
                <input type="checkbox" id="politica" name="politica" required>
                <label for="politica" class="labelInline">He leído y acepto <a href="legal.php" rel="noopener noreferrer" target="_blank">la política de privacidad</a>.<br>En resumen, esta política significa que no vamos a compartir tus datos con nadie, ni utilizarlos con otro fin más que resolver tu consulta. ¡Puedes estar tranquila!.</label>
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

<?php include 'footer.php'; ?>

</body>
</html>