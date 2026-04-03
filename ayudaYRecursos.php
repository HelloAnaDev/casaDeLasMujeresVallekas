<?php 
$pagina = 'ayudaYRecursos';
include 'header.php'; 
?>

<main>
    <section class="recursosIntro">
        <div class="tituloComun">
        <h2>Ayuda y recursos</h2>
        </div>
        <p>Directorio de recursos y servicios que pueden resultar de utilidad a las vecinas, ordenados por temáticas.</p>
        <p class="textoAlertaUrgencia">Si tienes una urgencia que necesita atención inmediata (Peligros inmediatos de violencia de género o riesgo de suicidio), toca el botón rojo de "Contactos urgentes" para encontrar rápidamente los contactos.</p>
    </section>

    <section class="recursosLayout">
        <nav class="recursosTabs" aria-label="Categorías de recursos">
            <button class="tabButton active" data-target="generales">Recursos generales y contacto</button>
            <button class="tabButton" data-target="formativo">Área formativo-laboral</button>
            <button class="tabButton" data-target="familiar">Área familiar</button>
            <button class="tabButton" data-target="saludMental">Salud mental</button>
            <button class="tabButton" data-target="violencia">Violencia de género</button>
            <button class="tabButton" data-target="sexual">Salud sexual, prevención y atención a la trata</button>
        </nav>

        <div class="recursosContenedorPaneles">
            
            <div id="generales" class="tabPanel active">
                <div class="recursosGrid">
                    <article class="recursoCard">
                        <h3>Casa de las Mujeres de Vallekas</h3>
                        <p>Contacto directo con la asociación, dirección y redes sociales.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 653 53 92 12</span>
                            <span><strong>Correo:</strong> casademujeresvk@gmail.com</span>
                            <span><strong>Dirección:</strong> C/ La Diligencia 10</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>Red de Espacios de Igualdad del Ayuntamiento de Madrid</h3>
                        <p>Recursos públicos municipales especializados en la promoción de la igualdad, el empoderamiento de las mujeres y la prevención, detección y reparación de la violencia de género.</p>
                        <a href="https://www.madrid.es/portales/munimadrid/es/Inicio/Igualdad-entre-mujeres-y-hombres/Espacios-de-Igualdad?vgnextoid=c5571026200a5310VgnVCM2000000c205a0aRCRD&vgnextchannel=c426c05098535510VgnVCM1000008a4a900aRCRD" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Acceder al recurso</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Red de Atención Integral Violencia de Género</h3>
                        <p>Directorio integral de atención de la Comunidad de Madrid.</p>
                        <a href="https://www.comunidad.madrid/servicios/servicios-sociales/red-atencion-integral-violencia-genero#" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Acceder al recurso</a>
                    </article>
                </div>
            </div>

            <div id="formativo" class="tabPanel">
                <div class="recursosGrid">
                    <article class="recursoCard">
                        <h3>FP (Básica, media, superior)</h3>
                        <p>Portal oficial con toda la oferta de Formación Profesional.</p>
                        <a href="https://todofp.es/inicio.html" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Ir a TodoFP</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Unidades de Formación e Inserción Laboral (UFIL)</h3>
                        <p>Guía de los cinco centros disponibles en Madrid y los estudios que pueden cursarse, direcciones y contacto.</p>
                        <a href="https://dgbilinguismoycalidad.educa.madrid.org/guiaparafamilias/centros.php?codigo=UFIL&z=1" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Consultar guía UFIL</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Aulas de Compensación Educativa (ACE)</h3>
                        <p>Destinadas a garantizar la atención educativa del alumnado en situaciones de desventaja o dificultades de adaptación (A partir de 15 años con desfase curricular).</p>
                        <a href="https://dgbilinguismoycalidad.educa.madrid.org/cuadernodeorientacion/centros.php?codigo=ACE" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Consultar centros ACE</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Espacio Mujer Madrid (EMMA) / Fundación José María Llanos</h3>
                        <p>Espacio de formación y empleo. Itinerarios personalizados, cursos, aula permanente de empleo y emprendimiento.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 91 785 62 34</span>
                            <span><strong>Correo:</strong> emma@fundacionjosemariadellanos.es</span>
                            <span><strong>Dirección:</strong> C/ Martos 185, 28053 Madrid</span>
                        </div>
                        <a href="https://www.espaciomujermadrid.es/espacio-mujer-madrid/" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Ver web principal</a>
                        <a href="https://www.instagram.com/emma.espaciomujer?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer" class="recursoEnlace" style="margin-top: 0.5rem;">Visitar Instagram</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Grupo Lábor</h3>
                        <p>Asociación sin ánimo de lucro dedicada al empleo y formación para mujeres en Villaverde. Realizan formaciones gratuitas principalmente de limpieza y hostelería.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 91 797 53 54</span>
                            <span><strong>Correo:</strong> secretaria.grupolabor@gmail.com</span>
                        </div>
                        <a href="https://intervencioncomunitariavillaverde.org/recurso2/grupo-labor/" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Conocer Grupo Lábor</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Hogar Sí (Fundación Rais)</h3>
                        <p>Buscan erradicar el sinhogarismo mediante viviendas House First, autonomía y recuperación, complementado con programas de empleo y economía social.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 91 110 89 84</span>
                            <span><strong>Correo:</strong> socios@hogarsi.org</span>
                        </div>
                        <a href="https://hogarsi.org/" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Visitar Hogar Sí</a>
                    </article>
                </div>
            </div>

            <div id="familiar" class="tabPanel">
                <div class="recursosGrid">
                    <article class="recursoCard">
                        <h3>Derivación especializada en servicios sociales</h3>
                        <p>Directorio de centros de servicios sociales municipales de Madrid.</p>
                        <a href="https://www.madrid.es/portales/munimadrid/es/Inicio/Servicios-sociales-y-salud/Servicios-sociales/Centros-de-Servicios-Sociales-Municipales/?vgnextoid=51886e0cfb6da010VgnVCM100000d90ca8c0RCRD&vgnextchannel=70e4c8eb248fe410VgnVCM1000000b205a0aRCRD" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Ver Centros Sociales</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Servicio de Orientación Jurídica del ICAM</h3>
                        <p>Para cualquier consulta legal. Es un servicio gratuito y proporcionan cita si es necesario.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 900 814 815</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>PREINFANT</h3>
                        <p>Programa de acompañamiento a la maternidad gratuito, dirigido a mujeres o familias embarazadas o con un hijo/a menor de tres años en situación de vulnerabilidad.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 610 704 500</span>
                            <span><strong>Correo:</strong> preinfantmadrid@abd-ong.org</span>
                        </div>
                        <a href="https://preinfant.org/" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Conocer PREINFANT</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Proyecto "Conviviendo" (Fundación Amigó)</h3>
                        <p>Servicio gratuito de resolución positiva de los conflictos entre adolescentes y sus familias.</p>
                        <a href="https://fundacionamigo.org/proyecto-conviviendo/" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Ver Proyecto Conviviendo</a>
                    </article>
                    <article class="recursoCard">
                        <h3>Fundación ANAR</h3>
                        <p>Servicio de ayuda directa a niños, niñas y adolescentes.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 900 20 20 10</span>
                        </div>
                    </article>
                </div>
            </div>

            <div id="saludMental" class="tabPanel">
                <div class="recursosGrid">
                    <article class="recursoCard">
                        <h3>Servicio gratuito de atención psicológica para jóvenes (CAM)</h3>
                        <p>Dirigido a jóvenes de 14 a 30 años. Funciona los 365 días del año (15:00 a 00:00) y sin límite de intervenciones.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono / WhatsApp:</strong> 900 143 000</span>
                            <span><strong>Correo:</strong> saludmental1430@madrid.org</span>
                        </div>
                        <a href="https://www.comunidad.madrid/servicios/juventud/servicio-asistencia-psicologica" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Acceder al servicio</a>
                    </article>
                    <article class="recursoCard urgenciaDestacada">
                        <h3>Prevención del suicidio</h3>
                        <p>Líneas de atención inmediata disponibles las 24 horas.</p>
                        <div class="recursoContacto urgenciaRojo">
                            <span><strong>Teléfono Nacional:</strong> 024</span>
                            <span><strong>Teléfono de la Esperanza:</strong> 717 003 717</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>Centros Municipales de Salud Comunitaria (CMS)</h3>
                        <p>Centros del distrito especializados en la promoción de la salud y prevención de la enfermedad. Atención gratuita.</p>
                        <a href="https://www.madrid.es/portales/munimadrid/es/Pinar-de-la-Elipa/Centros-Madrid-Salud-CMS-?vgnextoid=e194fd34988cc010VgnVCM1000000b205a0aRCRD&vgnextchannel=0c872e3d07cbe210VgnVCM2000000c205a0aRCRD" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Localizar CMS</a>
                    </article>
                    <article class="recursoCard">
                        <h3>COGAM (LGTBIQ+)</h3>
                        <p>Asesorías (Jurídica, médica, psicológica, sexológica), atención VIH/Sida, salud, prevención y programa de orientación a jóvenes.</p>
                        <a href="https://cogam.es/servicios-lgtb/" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Servicios COGAM</a>
                    </article>
                </div>
            </div>

            <div id="violencia" class="tabPanel">
                <div class="recursosGrid">
                    <article class="recursoCard urgenciaDestacada">
                        <h3>Teléfonos de emergencia y atención VG</h3>
                        <p>Atención inmediata ante situaciones de violencia de género.</p>
                        <div class="recursoContacto urgenciaRojo">
                            <span><strong>Información y asesoramiento:</strong> 016</span>
                            <span><strong>Emergencias:</strong> 112</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>Servicio de Atención a Víctimas de Violencia de Género (SAVG 24h)</h3>
                        <p>Servicio del Ayto de Madrid para intervención de emergencia (Pareja/expareja). 24h/365 días. Atención social, psicológica, jurídica y alojamiento protegido.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono gratuito:</strong> 900 222 100 (Indicar a Policía derivación a SAVG)</span>
                            <span><strong>Correo:</strong> savg24h@madrid.es</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>Barnahus (Casa de los niños)</h3>
                        <p>Servicio especializado que proporciona valoración y atención a niños, niñas y adolescentes víctimas de violencia sexual y a sus familias.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono Información:</strong> 900 730 484</span>
                            <span><strong>Correo:</strong> casabarnahus@madrid.org</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>Asociación Candelita - Centro de Día Pachamama</h3>
                        <p>Destinado a mujeres en situación de VG y/o en riesgo de exclusión social. Cuenta con un programa específico para mujeres iberoamericanas.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 91 523 58 45</span>
                            <span><strong>Correo:</strong> candelita@candelita.org</span>
                            <span><strong>Dirección:</strong> C/ Sancho Dávila 19, local. Madrid</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>Federación de Mujeres Progresistas</h3>
                        <p>Atención integral a víctimas de VG: acogida, atención psicológica, asesoramiento jurídico y social.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 91 539 02 38</span>
                            <span><strong>Correo:</strong> comunicacion@fmujeresprogresistas.org</span>
                        </div>
                        <a href="https://fmujeresprogresistas.org/hacemos/violencia-de-genero/" target="_blank" rel="noopener noreferrer" class="recursoEnlace">Más información</a>
                    </article>
                </div>
            </div>

            <div id="sexual" class="tabPanel">
                <div class="recursosGrid">
                    <article class="recursoCard">
                        <h3>Centro "Concepción Arenal" (Ayto. Madrid)</h3>
                        <p>Atención específica a mujeres en situación de prostitución y/o víctimas de trata. Áreas: social, psicológica, jurídica y empleo. Disponen de alojamiento.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 91 468 08 53 / 671 060 297</span>
                            <span><strong>Correo:</strong> arenal@dinamia.org</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>CIMASCAM (Agresiones sexuales)</h3>
                        <p>Atención social, jurídica y psicológica a mujeres víctimas de agresiones sexuales y su entorno familiar.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 91 534 09 22</span>
                            <span><strong>Dirección:</strong> C/ Doctor Santero 12, 28039</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>APRAMP</h3>
                        <p>Atención especializada e integral en trata de mujeres. Cuentan con unidad móvil y centros de acogida.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono 24h:</strong> 609 589 479</span>
                            <span><strong>Correo:</strong> apramp@apramp.org</span>
                        </div>
                    </article>
                    <article class="recursoCard">
                        <h3>Oblatas Madrid</h3>
                        <p>Intervención integral con mujeres en situación de prostitución, víctimas de trata y/o exclusión. Cuentan con pisos tutelados, centro de día y unidad móvil.</p>
                        <div class="recursoContacto">
                            <span><strong>Teléfono:</strong> 91 501 56 97 / 620 175 642</span>
                            <span><strong>Correo:</strong> info@programaoblatasmadrid.org</span>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <dialog id="modalUrgencias" class="modalUrgencias">
        <div class="modalContenedorInterior">
            <button id="cerrarModal" class="cerrarModalBtn">✖</button>
            <h2 class="tituloModalRojo">Contactos Urgentes</h2>
            <div class="recursosGrid">
                <article class="recursoCard urgenciaDestacada">
                    <h3>Prevención del suicidio</h3>
                    <p>Líneas de atención inmediata disponibles las 24 horas.</p>
                    <div class="recursoContacto urgenciaRojo">
                        <span><strong>Teléfono Nacional:</strong> 024</span>
                        <span><strong>Teléfono de la Esperanza:</strong> 717 003 717</span>
                    </div>
                </article>
                <article class="recursoCard urgenciaDestacada">
                    <h3>Teléfonos de emergencia y atención VG</h3>
                    <p>Atención inmediata ante situaciones de violencia de género.</p>
                    <div class="recursoContacto urgenciaRojo">
                        <span><strong>Información y asesoramiento:</strong> 016</span>
                        <span><strong>Emergencias:</strong> 112</span>
                    </div>
                </article>
            </div>
        </div>
    </dialog>

    <button id="btnFlotanteUrgencias" class="btnFlotanteUrgencias">
        <span class="iconoAlerta">⚠</span> Contactos urgentes
    </button>

</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // --- LÓGICA DE PESTAÑAS (TABS) ---
    const tabButtons = document.querySelectorAll('.tabButton');
    const tabPanels = document.querySelectorAll('.tabPanel');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanels.forEach(panel => panel.classList.remove('active'));

            button.classList.add('active');

            const targetId = button.getAttribute('data-target');
            document.getElementById(targetId).classList.add('active');
        });
    });

    // --- LÓGICA DEL MODAL DE URGENCIAS ---
    const btnAbrirModal = document.getElementById('btnFlotanteUrgencias');
    const modalUrgencias = document.getElementById('modalUrgencias');
    const btnCerrarModal = document.getElementById('cerrarModal');

    if (btnAbrirModal && modalUrgencias && btnCerrarModal) {
        btnAbrirModal.addEventListener('click', () => {
            modalUrgencias.showModal();
        });

        btnCerrarModal.addEventListener('click', () => {
            modalUrgencias.close();
        });

        modalUrgencias.addEventListener('click', (event) => {
            const rect = modalUrgencias.getBoundingClientRect();
            const isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
                                rect.left <= event.clientX && event.clientX <= rect.left + rect.width);
            if (!isInDialog) {
                modalUrgencias.close();
            }
        });
    }
});
</script>

<?php include 'footer.php'; ?>