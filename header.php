<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    // --- DEFINIMOS LA RUTA BASE ABSOLUTA ---
    // Esto asegura que el CSS y los enlaces funcionen desde cualquier subcarpeta
    $base_url = '/TFG/'; 
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de las mujeres Vallekas</title>
    
    <link rel="stylesheet" href="<?php echo $base_url; ?>style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Italianno&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
<header class="cabecera">
    <a href="<?php echo $base_url; ?>index.php" id="contenedorLogoMovil">
        <img src="<?php echo $base_url; ?>images/logoHorizontal.png" id="logoMovil" alt="Logotipo de la 'Casa de las Mujeres de Vallekas'. Tres mujeres diferentes, unidas, formando una casa con sus brazos.">
    </a>   

    <button id="btnMenu" aria-label="Abrir menú">☰</button>

    <nav id="menuLateral">
        <button id="btnOcultar" aria-label="Ocultar menú">✖ Ocultar menu</button>   

<a 

        <?php
        if ($pagina==='index') {
            echo 'class="seccionActual"';
        }
        ?>

        href="<?php echo $base_url; ?>index.php">Inicio</a>

<a

        <?php 
        if ($pagina === 'quienesSomos') {
            echo 'class="seccionActual"';
        }
        ?>
        
        href="<?php echo $base_url; ?>quienesSomos.php">Quiénes somos</a>

<a 
        
        <?php
        if ($pagina==='casaEnMarcha') {
            echo 'class="seccionActual"';
        }
        ?>

        href="<?php echo $base_url; ?>casaEnMarcha.php">La casa en marcha</a>

<a 
        
        <?php
        if($pagina==='index') {
            echo 'class="seccionActual"';
        }
        ?>
        
        href="<?php echo $base_url; ?>index.php" id="contenedorLogo"><img src="<?php echo $base_url; ?>images/logoHorizontal.png" id="logoHorizontal" alt="Logotipo de la 'Casa de las Mujeres de Vallekas'. Tres mujeres diferentes, unidas, formando una casa con sus brazos."></a>

<a 
        
        <?php
        if ($pagina==='colabora')  {
            echo 'class="seccionActual"';
        }
        ?>

        href="<?php echo $base_url; ?>colabora.php">Colabora</a>

<a
        
        <?php
        if ($pagina==='contacto') {
            echo 'class="seccionActual"';
        }
        ?>
        
        href="<?php echo $base_url; ?>contacto.php">Contacto</a>

<a
        
        <?php
        if ($pagina==='ayudaLegal') {
            echo 'class="seccionActual"';
        }
        ?>
        
        href="<?php echo $base_url; ?>ayudaLegal.php">Ayuda Legal</a>

    </nav> 
</header>