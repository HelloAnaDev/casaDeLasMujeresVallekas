<?php

require_once 'config/config.php'; 


$stmtUltimo = $pdo->query("SELECT fecha_registro FROM registro_feminicidios ORDER BY fecha_registro DESC LIMIT 1");
$ultimoCaso = $stmtUltimo->fetch(PDO::FETCH_ASSOC);

$lutoActivo = false; 

if ($ultimoCaso && isset($ultimoCaso['fecha_registro'])) {
    $fechaFeminicidio = new DateTime($ultimoCaso['fecha_registro']);
    $fechaHoy = new DateTime();
    
    $fechaFeminicidio->setTime(0, 0, 0);
    $fechaHoy->setTime(0, 0, 0);
    
    $diferenciaDias = $fechaHoy->diff($fechaFeminicidio)->days;
    
    if ($diferenciaDias <= 1 && $fechaFeminicidio <= $fechaHoy) {
        $lutoActivo = true;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de las mujeres Vallekas</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/style.css?v=2.2">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Italianno&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>/images/favicon.png">
</head>

<body class="<?php echo $lutoActivo ? 'modo-luto' : ''; ?>">
<header class="cabecera">
    <a href="<?php echo BASE_URL; ?>/index.php" id="contenedorLogoMovil">
        <img src="<?php echo BASE_URL; ?>/images/logoHorizontal.png" id="logoMovil" alt="Logotipo de la 'Casa de las Mujeres de Vallekas'.">
    </a>   

    <button id="btnMenu" aria-label="Abrir menú">☰</button>

    <nav id="menuLateral">
        <button id="btnOcultar" aria-label="Ocultar menú">✖ Ocultar menu</button>   

        <a <?php if ($pagina==='index') echo 'class="seccionActual"'; ?> href="<?php echo BASE_URL; ?>/index.php">Inicio</a>
        <a <?php if ($pagina==='quienesSomos') echo 'class="seccionActual"'; ?> href="<?php echo BASE_URL; ?>/quienesSomos.php">Quiénes somos</a>
        <a <?php if ($pagina==='casaEnMarcha') echo 'class="seccionActual"'; ?> href="<?php echo BASE_URL; ?>/casaEnMarcha.php">La casa en marcha</a>

        <a href="<?php echo BASE_URL; ?>/index.php" id="contenedorLogo">
            <img src="<?php echo BASE_URL; ?>/images/logoHorizontal.png" id="logoHorizontal" alt="Logotipo">
        </a>

        <a <?php if ($pagina==='colabora') echo 'class="seccionActual"'; ?> href="<?php echo BASE_URL; ?>/colabora.php">Colabora</a>
        <a <?php if ($pagina==='contacto') echo 'class="seccionActual"'; ?> href="<?php echo BASE_URL; ?>/contacto.php">Contacto</a>
        <a <?php if ($pagina==='ayudaYRecursos') echo 'class="seccionActual"'; ?> href="<?php echo BASE_URL; ?>/ayudaYRecursos.php">Ayuda y recursos</a>
    </nav> 
</header>