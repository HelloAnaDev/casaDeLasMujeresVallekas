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
<aside class="sidebarAdmin">
    <div class="sidebarTitulo">
        <img src="images/logoVector.png" id="sidebarLogo" alt="Logotipo de la 'Casa de las Mujeres de Vallekas'.">
        <h2>Panel de administración</h2>
</div>   

<nav class="sidebarNav">
    <ul>
        <li> <a href="inicio.php">Inicio</a></li>
        <li> <a href="agenda.php">Gestión de agenda</a></li>
        <li> <a href="reservas.php">Control de reservas</a></li>
    </ul>
</nav>

<div class="sidebarUser">
    <!-- avatar con su foto -->
    <img src="" alt="">
    <p>Hola, [$nombreAdmin¨]</p>
        <div class="userActions">
            <a href="perfil.php" class="btnUser">Mi perfil</a>
            <a href="logout.php" class="btnUser btnLogout">Cerrar sesión</a>
        </div>
</div>
</aside>










    <button id="btnMenu" class="menuToggle" aria-label="Abrir menú">☰</button>

    <nav id="menuLateral">
        <button id="btnOcultar" aria-label="Ocultar menú">✖ Ocultar menu</button>   
<!-- Inicio -->
        <a 

        <?php
        if ($pagina==='index') {
            echo 'class="seccionActual"';
        }
        ?>

        href="index.php">Inicio</a>

<!-- Quienes somos -->

        <a

        <?php 
        if ($pagina === 'quienesSomos') {
            echo 'class="seccionActual"';
        }
        ?>
        
        href="quienesSomos.php">Quiénes somos</a>

<!-- Agenda y actividades -->
 
        <a 
        
        <?php
        if ($pagina==='agendaActividades') {
            echo 'class="seccionActual"';
        }
        ?>

        href="agendaActividades.php">Agenda y actividades</a>

<!-- Inicio -->
 
        <a 
        
        <?php
        if($pagina==='index') {
            echo 'class="seccionActual"';
        }
        ?>
        
        href="index.php" id="contenedorLogo"><img src="images/logoHorizontal.png" id="logoHorizontal" alt="Logotipo de la 'Casa de las Mujeres de Vallekas'. Tres mujeres diferentes, unidas, formando una casa con sus brazos."></a>

<!-- Colabora -->
 
        <a 
        
        <?php
        if ($pagina==='colabora')  {
            echo 'class="seccionActual"';
        }
        ?>

        href="colabora.php">Colabora</a>

<!-- Contacto -->
 
        <a
        
        <?php
        if ($pagina==='contacto') {
            echo 'class="seccionActual"';
        }
        ?>
        
        href="contacto.php">Contacto</a>

<!-- Area privada, login -->
 
        <a
        
        href="login.php" class="boton         
        <?php
        if ($pagina==='login') {
            echo "seccionActual" ;}?>">Área privada</a>
    </nav> 
</aside>