<?php 
$pagina = 'registro';
include 'header.php'; 
?>

<main>


    <div id="contenedorRegistro">
        <div id="mensajeNotificacion" class="oculto"></div>
        <form action="backend/procesarRegistro.php" method="post" class="formularioMensaje">
            <label for="nombreUser">Nombre</label>
            <input name="nombreUser" type="text" id="nombreUser" placeholder="María"required>
            <label for="apellidoUser">Apellidos</label>
            <input name="apellidoUser" type="text" id="apellidoUser" placeholder="García Romero"required>
            <label for="correoUser">Correo electrónico</label>
            <input type="email" id="correoUser" name="correoUser" placeholder="ejemplo@correo.com">
            <label for="telefonoUser">Teléfono</label>
            <input type="tel" id="telefonoUser" name="telefonoUser" placeholder="600 000 000"required>
            <label for="contrasenaUser">Contraseña</label>
            <input type="password" id="contrasenaUser" name="contrasenaUser"required>
            <label for="password_repeat">Repite tu contraseña</label>
            <input type="password" id="password_repeat" name="password_repeat"required>            

            <div class="checkbox">
                <input type="checkbox" id="politica" name="politica" required>
                <label for="politica" class="labelInline"required>He leído y acepto <a href="legal.php">la política de privacidad</a>.<br>En resumen, esta política significa que no vamos a compartir tus datos con nadie, ni utilizarlos con otro fin más que poder enviarte información de las actividades y talleres, pero nada de publicidad e información inutil y pesada. ¡Puedes estar tranquila!.</label>
            </div>
    <div class="campoOculto" aria-hidden="true">
    <label for="sitioWeb2">Campo de verificación para no humanos.</label>
    <input type="text" id="sitioWeb" name="sitioWeb2" tabindex="-1" autocomplete="off">
</div>
            <button type="submit" class="btnEnvio">Aceptar</button>
        </form>    
    </div>

</main>

<?php include 'footer.php'; ?>

<script src="interaccion.js"></script>
</body>
</html>