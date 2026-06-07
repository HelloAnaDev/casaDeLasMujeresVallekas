<?php
$pagina = 'colabora';
include 'header.php';
?>

<main>
    <div class="tituloComun">
        <h2>¿Cómo puedo colaborar?</h2>
    </div>

    <div class="seccion-colabora-tabs">
        
        <nav class="colabora-nav-lateral">
            <button class="btn-tab-lateral btn-destacado-socia active" data-tab="socias">¡Hazte socia!</button>
            <button class="btn-tab-lateral" data-tab="teaming">1€ al mes con Teaming</button>
            <button class="btn-tab-lateral" data-tab="transferencia">Donación económica puntual</button>
            <button class="btn-tab-lateral" data-tab="objetos">Donación de objetos</button>
            <button class="btn-tab-lateral" data-tab="tiempo">Colabora con tu tiempo</button>
        </nav>

        <div class="colabora-contenido-paneles">
            
            <section id="tab-socias" class="panel-colabora active">
                <h3>¡HAZTE SOCIA!</h3>
                <p>En el barrio sabemos bien que las cosas nunca nos las han regalado; las hemos conseguido juntas, apoyándonos hombro con hombro. La Casa de las Mujeres nació de esa misma rebeldía y apoyo mutuo, y para seguir abiertas y fuertes, te necesitamos.</p>
                
                <p>Ser socia de La Casa es mucho más que firmar un papel. Cuantas más mujeres formemos parte de esta red oficial, **más fuerza tendremos al levantar la voz**. No es lo mismo ir a hablar con las instituciones, con la junta del distrito o reclamar recursos siendo unas pocas, que yendo respaldadas por cientos de vecinas. Al hacerte socia, nos haces más visibles, más respetadas y logramos que se nos escuche de verdad. Es nuestra forma de demostrar que somos una comunidad unida y activa.</p>
                
                <p>Puedes rellenar tus datos en el formulario online aquí abajo, o si lo prefieres de la forma tradicional, descargar el papel en PDF para imprimirlo, rellenarlo tranquilamente y traérnoslo un día a La Casa en persona.</p>
                
                <a href="archivos/formulario_socia.pdf" download class="botonBase" style="background-color: var(--purpuraMedio); color: #241a22; margin-bottom: 2rem;">Descargar formulario en PDF</a>

                <div id="mensajeNotificacionSocia" class="oculto"></div>
                
                <form action="backend/procesarSocia.php" method="post" class="formularioMensaje">
                    <label for="nombre_socia">Nombre y apellidos <span style="color:red;">*</span></label>
                    <input name="nombre_socia" type="text" id="nombre_socia" placeholder="Ej: María García Romero" required>

                    <label for="dni_socia">DNI / NIE <span style="color:red;">*</span></label>
                    <input name="dni_socia" type="text" id="dni_socia" placeholder="Ej: 12345678A" required>

                    <label for="telefono_socia">Teléfono <span style="color:red;">*</span></label>
                    <input name="telefono_socia" type="tel" id="telefono_socia" placeholder="Ej: 600 000 000" required>

                    <label for="direccion_socia">Dirección <span style="color:red;">*</span></label>
                    <input name="direccion_socia" type="text" id="direccion_socia" placeholder="Ej: Calle de la Diligencia, 10" required>

                    <label for="email_socia">Correo electrónico</label>
                    <input name="email_socia" type="email" id="email_socia" placeholder="Ej: vecina@correo.com">

                    <fieldset class="grupoRadios" style="background-color: var(--purpuraMasClaro); padding: 15px; border-radius: 12px; margin-top: 15px; border: 1px solid var(--purpuraMedio);">
                        <legend style="padding: 0 10px; font-weight: bold; color: var(--purpuraOscuro);">Aportación voluntaria</legend>
                        <p style="font-size: 0.9rem; margin-top:0;">Si deseas contribuir económicamente con el mantenimiento y actividades del proyecto, puedes hacerlo tanto con donaciones puntuales como pagando una cuota fija todos los meses (seleccionando en tu banco "transferencia periódica"). En cualquiera de los dos casos, aquí dejamos la cuenta donde domiciliar o ingresar según tu criterio.</p>
                        <p style="font-size: 0.9rem; margin-bottom: 0;"><strong>Concepto indispensable:</strong> “CUOTA DE SOCIA CASA DE LAS MUJERES DE VALLEKAS” o “DONACIÓN CASA DE LAS MUJERES DE VALLEKAS”.<br>
                        <strong>LA CAIXA:</strong> ES89 2100 2378 8102 0019 3231</p>
                    </fieldset>

                    <div class="checkbox" style="margin-top: 15px;">
                        <input type="checkbox" id="politica_socia" name="politica_socia" required>
                        <label for="politica_socia" class="labelInline" style="font-weight: normal; font-size: 0.85rem; color: #333; text-align: justify; display: block;">
                            He leído y acepto la política de privacidad. <strong>Para tu total tranquilidad:</strong> guardaremos los datos que nos dejas aquí con muchísimo cuidado en nuestro fichero interno de Socias. Solo los usaremos para llevar el registro de la asociación y poder avisarte de las reuniones, talleres o cosas importantes de La Casa. Jamás compartiremos tus datos con nadie de fuera ni los usaremos de mala manera. Todo está protegido de forma legal según el Reglamento Europeo (RGPD) y la normativa vigente. Si en algún momento decides que quieres darte de baja, solo tienes que escribirnos un correo a casademujeresvk@gmail.com y borraremos todo de inmediato para que estés completamente tranquila.
                        </label>
                    </div>

                    <div class="campoOculto" aria-hidden="true">
                        <label for="sitioWebSocia">Verificación</label>
                        <input type="text" id="sitioWebSocia" name="sitioWebSocia" tabindex="-1" autocomplete="off">
                    </div>

                    <button type="submit" class="btnEnvio">Enviar solicitud de socia</button>
                </form>
            </section>

            <section id="tab-teaming" class="panel-colabora">
                <h3>1€ al mes con Teaming</h3>
                <p>Un euro al mes parece invisible, pero cuando se junta el tuyo con el de ella y el de todas, se convierte en un refugio, en un taller, en una mano tendida y en una oportunidad.</p>
                <p>No es el valor de una moneda, es el valor de saber que no estamos solas. ¿Te unes a nuestro grupo de Teaming? Con el precio de un café al mes, construimos un hogar para todas.</p>
                <a href="https://www.teaming.net/casadelasmujeresdevallecas" rel="noopener noreferrer" target="_blank" class="botonBase">Quiero ayudar</a>
            </section>

            <section id="tab-transferencia" class="panel-colabora">
                <h3>Donación económica puntual</h3>
                <p>A veces, lo que para nosotros es el presupuesto de una tarde de cine o de unas cañas, para la Casa de las Mujeres significa el material de un taller, una consulta de asesoramiento o mantener nuestras puertas abiertas una semana más.</p>
                <p>Si hoy te apetece sumar, puedes hacer una donación esporádica por transferencia. Sin cuotas, sin compromisos a largo plazo, solo un "aquí estoy" cuando tú quieras y puedas. ¡Gracias por ser parte de nuestra red!</p>
                
                <div style="background-color: var(--purpuraMasClaro); padding: 20px; border-radius: 15px; margin-top: 20px; border-left: 4px solid var(--purpuraOscuro);">
                    <h4 style="margin-top: 0; color: var(--purpuraOscuro); font-size: 1.2rem;">Transferencia bancaria:</h4>
                    <p style="margin: 5px 0;"><strong>Beneficiario:</strong> Casa de las mujeres Vallekas</p>
                    <p style="margin: 5px 0;"><strong>IBAN:</strong> ES89 2100 2378 8102 0019 3231</p>
                    <p style="margin: 5px 0;"><strong>Concepto:</strong> DONACIÓN CASA DE LAS MUJERES DE VALLEKAS</p>
                </div>
            </section>

            <section id="tab-objetos" class="panel-colabora">
                <h3>Donación de objetos</h3>
                <p>A veces, lo que a ti ya no te sirve, en la Casa de las Mujeres es justo lo que necesitamos. Desde material de oficina o escolar, materiales variados para talleres o mobiliario que pueda dar vida a nuestras salas.</p>
                <p>Antes de deshacerte de algo que esté en buen estado, pregúntanos. Ayudarnos a equipar nuestro espacio es ayudarnos a que sea un lugar más digno y acogedor para todas. ¡Démosle una segunda vida a las cosas con un propósito social!</p>
                <p>Si tienes algo que nos pueda ayudar, contacta con nosotras para hablar y ver qué tan útil nos puede ser.</p>
                <a href="contacto.php" class="botonBase">Contacta con nosotras</a>
            </section>

            <section id="tab-tiempo" class="panel-colabora">
                <h3>Colabora con tu tiempo</h3>
                <p>¿Sabes de informática, de yoga, de derecho, de gestión emocional o de cualquier otra disciplina? En la Casa de las Mujeres creemos que todas tenemos conocimientos valiosos y útiles que merecen ser compartidos.</p>
                <p>Si tienes un ratito a la semana, o al mes, o incluso puntual, y te apetece dar un taller, una charla o una clase, nuestras puertas están abiertas. No buscamos "expertas mundiales", buscamos mujeres con ganas de enseñar y aprender juntas. ¡Tu tiempo es el mejor regalo que nos puedes hacer!</p>
                <p>Si es así, contacta con nosotras para hablar y ponernos manos a la obra.</p>
                <a href="contacto.php" class="botonBase">Contacta con nosotras</a>
            </section>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const botones = document.querySelectorAll('.btn-tab-lateral');
    const paneles = document.querySelectorAll('.panel-colabora');

    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            botones.forEach(b => b.classList.remove('active'));
            paneles.forEach(p => p.classList.remove('active'));

            boton.classList.add('active');
            const tabId = boton.getAttribute('data-tab');
            document.getElementById(`tab-${tabId}`).classList.add('active');
        });
    });

    const params = new URLSearchParams(window.location.search);
    const estado = params.get('socia');
    const cajaMsg = document.getElementById('mensajeNotificacionSocia');
    
    if (estado && cajaMsg) {
        botones.forEach(b => b.classList.remove('active'));
        paneles.forEach(p => p.classList.remove('active'));
        document.querySelector('[data-tab="socias"]').classList.add('active');
        document.getElementById('tab-socias').classList.add('active');
        
        if (estado === 'success') {
            cajaMsg.textContent = "¡Solicitud enviada correctamente! Bienvenida a la red de socias de la Casa de mujeres Vallekas.";
            cajaMsg.className = "alerta alerta-exito";
        } else {
            cajaMsg.textContent = "Hubo un problema al tramitar la solicitud. Por favor, inténtalo de nuevo, si no se soluciona por favor ponte en contacto con nosotras en el número 676533739. Te atenderá nuestra informática para tomar nota del problema y tus datos para darte de alta lo antes posible. ¡Gracias!";
            cajaMsg.className = "alerta alerta-error";
        }
        cajaMsg.scrollIntoView({ behavior: 'smooth' });
    }
});
</script>

<?php include 'footer.php'; ?>