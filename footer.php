<?php
if (!isset($base_url)) {
    $base_url = '/TFG/';
}
?>

<?php 
require_once __DIR__ . '/config/config.php'; 

$stmtUltimo = $pdo->query("SELECT fecha_registro, nombre, tipo_victima FROM registro_feminicidios ORDER BY fecha_registro DESC LIMIT 1");
$ultimoCaso = $stmtUltimo->fetch();

$diasSinVictimas = 0;
if ($ultimoCaso) {
    $fechaUltimo = new DateTime($ultimoCaso['fecha_registro']);
    $hoy = new DateTime();
    $diasSinVictimas = $hoy->diff($fechaUltimo)->days;
}

$stmtAnual = $pdo->query("SELECT tipo_victima, COUNT(*) as total FROM registro_feminicidios WHERE YEAR(fecha_registro) = YEAR(CURDATE()) GROUP BY tipo_victima");
$stats = $stmtAnual->fetchAll(PDO::FETCH_KEY_PAIR);

$mujeresEsteAno = $stats['mayor'] ?? 0;
$ninasEsteAno = $stats['menor'] ?? 0;
?>

<button id="btnContadorFlotante" class="contadorFlotante" aria-label="Abrir información del contador">
    <span class="diasContador"><strong><?php echo $diasSinVictimas; ?></strong> días</span>
    <div class="zonaInfo">
    <span class="signoPregunta">?</span>
    <span class="textoHover">¿Por qué contamos?</span>
    </div>
</button>

<dialog id="modalManifiesto" class="modalFeminismos">
    <div class="modalContenido">
        <button id="btnCerrarModal" class="cerrarModal" aria-label="Cerrar manifiesto">✖</button>
        
        <h3>¿Por qué contamos los días?</h3>
        <p>Este contador no es una estadística, es una exigencia de vida. Las voluntarias de La Casa actualizamos este número como un acto de memoria, resistencia y visibilización.</p>
        <p>Reivindicamos que el único número aceptable es que no falte ni una más.</p>
        <p>Sin embargo, este año ya han sido asesinadas <strong><?php echo $mujeresEsteAno; ?> mujeres</strong> y <strong><?php echo $ninasEsteAno; ?> niñas</strong> por violencia machista.</p>
        <?php 
        if ($ultimoCaso && $ultimoCaso['tipo_victima'] === 'mayor' && !empty($ultimoCaso['nombre'])): 
        ?>
            <p class="textoMemoria">El último nombre de mujer que sumamos a nuestra memoria es <strong><?php echo htmlspecialchars($ultimoCaso['nombre']); ?></strong>. Por ella, y por todas, seguimos contando.</p>
        <?php endif; ?>
        
     <div class="redSeguridad">
            <h3>No estás sola</h3>
            <p>Si tú o alguna mujer de tu entorno está sufriendo violencia, hemos tejido una red para sostenernos.</p>
            <div class="botonesAyuda">
                <a href="tel:016" class="btn016">Llama al 016 <span>(Atención a víctimas, no deja rastro en la factura)</span></a>
                <a href="contacto.php" class="btnLegal">Contacta con nosotras</a>
            </div>
        </div>
    </div>
</dialog>

<footer class="piePagina">
    <div class="pieColumnas">
        
        <div class="columnaLogo">
            <a href="<?php echo $base_url; ?>index.php">
                <img src="<?php echo BASE_URL; ?>/images/logoVector.png" alt="Logotipo de la Casa de las Mujeres de Vallekas">
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
                <li><a href="https://maps.app.goo.gl/9rxrcuWJwi8xCzYb8" rel="noopener noreferrer" target="_blank">Calle Diligencia, 10 (entrada por calle Volver a Empezar) <br> 28018, Puente de Vallecas. Madrid.</a></li>
            </ul>
        </div>
        <div class="columnaEnlaces">
            <span class="tituloPie">INFORMACIÓN LEGAL</span>
            <ul>
                <li><a href="legal.php" rel="noopener noreferrer" target="_blank">Aviso legal</a></li>                
                <li><a href="legal.php" rel="noopener noreferrer" target="_blank">Política de Privacidad</a></li>
                <li><a href="legal.php" rel="noopener noreferrer" target="_blank">Política de cookies</a></li>
                <li><a href="legal.php" rel="noopener noreferrer" target="_blank">Términos y condiciones</a></li>
            </ul>
            <span class="tituloPie espaciadoExtra">ÁREA PRIVADA</span>
            <ul>
                <li><a href="login.php">Acceso administración</a></li>
            </ul>
        </div>
    </div>

    <div class="pieCreditos">
        <p>2026 &copy; Casa de las Mujeres Vallekas</p>
        <p>Desarrollado por <a  target="_blank" rel="noopener noreferrer">Hello.ana.dev</a></p>
    </div>
    <script src="<?php echo BASE_URL; ?>/datosCalendario.js"></script>
<script src="<?php echo BASE_URL; ?>/interaccion.js"></script>
</footer>
<script src="<?php echo $base_url; ?>interaccion.js"></script>