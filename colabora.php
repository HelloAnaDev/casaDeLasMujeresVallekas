<?php
$pagina='colabora';
include 'header.php';
?>

<main>
<div class="tituloComun">
<h2>¿Cómo puedo colaborar?</h2>
</div>

<div class="colaboracion" >

<!-- teaming -->
<input type="radio" name="option" id="teaming" checked>
<label for="teaming">
<div class="tituloTab"> 1€ al mes con Teaming </div>
    <div class="contenidoTab">
    <h3>1€ al mes con Teaming</h3>
    <p>Un euro al mes parece invisible, pero cuando se junta el tuyo con  el de ella y el de todas, se convierte en un refugio, en un taller, en una mano tendida y en una oportunidad.</p>

    <p>No es el valor de una moneda, es el valor de saber que no estamos solas. ¿Te unes a nuestro grupo de Teaming? Con el precio de un café al mes, construimos un hogar para todas.</p>

<button href="https://www.teaming.net/casadelasmujeresdevallecas" rel="noopener noreferrer" target="_blank">Quiero ayudar</button>

</div></label>

<!-- banco -->
<input type="radio" name="option" id="transferencia">
<label for="transferencia">
<div class="tituloTab">Donación puntual</div>
    <div class="contenidoTab">
    <h3>Donación puntual</h3>
    <p>A veces, lo que para nosotros es el presupuesto de una tarde de cine o de unas cañas, para la Casa de las Mujeres significa el material de un taller, una consulta de asesoramiento o mantener nuestras puertas abiertas una semana más.</p>

    <p>Si hoy te apetece sumar, puedes hacer una donación esporádica por transferencia. Sin cuotas, sin compromisos a largo plazo, solo un "aquí estoy" cuando tú quieras y puedas. ¡Gracias por ser parte de nuestra red!</p>
    <h3>Transferencia bancaria:</h3>
    <p>Beneficiario: Casa de las muejres Vallekas</p>
    <p>IBAN: ES89 2100 2378 8102 0019 3231</p>
    <p>Concepto: Donación</p>

    <!-- <p>¿Quieres hacer una aportación mensual? En ese caso, <strong>pásate por la Casa</strong>, </p> -->

</div></label>

<!-- objetos -->
<input type="radio" name="option" id="objetos">
<label for="objetos">
<div class="tituloTab">Donación de objetos</div>
    <div class="contenidoTab">
    <h3>Objetos variados</h3>
    <p>A veces, lo que a ti ya no te sirve, en la Casa de las Mujeres es justo lo que necesitamos. Desde material de oficina o escolar, materiales variados para talleres o mobiliario que pueda dar vida a nuestras salas.</p>

    <p>Antes de deshacerte de algo que esté en buen estado, pregúntanos. Ayudarnos a equipar nuestro espacio es ayudarnos a que sea un lugar más digno y acogedor para todas. ¡Démosle una segunda vida a las cosas con un propósito social!

    <p>Si tienes algo que nos pueda ayudar, <a href="contacto.php">contacta con nosotras</a> para hablar y ver qué tan útil nos puede ser.</p>
</p>
</div></label>

<!-- voluntariado -->
<input type="radio" name="option" id="voluntariado">
<label for="voluntariado">
<div class="tituloTab">Voluntariado</div>
    <div class="contenidoTab">
    <h3>Voluntariado</h3>
    <p>¿Sabes de informática, de yoga, de derecho, de gestión emocional o de cualquier otra disciplina? En la Casa de las Mujeres creemos que todas tenemos conocimientos valiosos y útiles que merecen ser compartidos.</p>

    <p>Si tienes un ratito a la semana, o al mes, o incluso puntual, y te apetece dar un taller, una charla o una clase, nuestras puertas están abiertas. No buscamos "expertas mundiales", buscamos mujeres con ganas de enseñar y aprender juntas. ¡Tu tiempo es el mejor regalo que nos puedes hacer!</p>

    <p>Si es así, <a href="contacto.php">contacta con nosotras</a> para hablar y ponernos manos a la obra.</p>

</div></label>
</div>

</main>

<?php include 'footer.php'; ?>

</body>
</html>