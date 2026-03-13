<?php
$pagina='login';
include 'header.php';
?>

<main>

<div id="userContrasena">
    <label for="user">Usuaria</label>
    <input type="tel" id="telefonUser" name="telefonoUser">
    <label for="telefono">Contraseña</label>
    <input type="tel" id="contrasena" name="contrasena">

    <button type="submit" class="btnEnvio">Acceder</button>
        
</div>

</main>

<?php include 'footer.php'; ?>

<script src="interaccion.js"></script>
</body>
</html>