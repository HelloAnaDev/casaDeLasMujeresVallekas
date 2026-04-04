<?php require_once '../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de las mujeres Vallekas</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/style.css?v=1.3">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Italianno&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>/images/favicon.png">

</head>
<body>

<button id="btnMenuAdmin" aria-label="Abrir menú">☰</button>

<aside class="sidebarAdmin" id="sidebarContenedor">

    <button id="btnOcultarAdmin" aria-label="Ocultar menú">✖</button>

        
<div class="sidebarTitulo">
    <a href="inicioAdmin.php">
        <img src="<?php echo BASE_URL; ?>/images/logoVector.png" class="sidebarLogo" alt="Logotipo de la 'Casa de las Mujeres de Vallekas'.">
    </a>
</div>   

<nav class="sidebarNav">
    
   <ul>
    <li> 
        <a href="comentariosAdmin.php" class="navLink <?php if (isset($pagina) && $pagina === 'adminComentarios') echo 'active'; ?>">Moderar comentarios</a>
    </li>    

    <li> 
        <a href="memoriasAdmin.php" class="navLink <?php if (isset($pagina) && $pagina === 'adminMemorias') echo 'active'; ?>">Memorias de "La casa en marcha"</a>
    </li>

    <li> 
        <a href="contadorAdmin.php" class="navLink <?php if (isset($pagina) && $pagina === 'adminContador') echo 'active'; ?>">Contador</a>
    </li>
</ul>

</nav>

<div class="sidebarUser">
    <p>¡Hola, <strong><?php echo htmlspecialchars($_SESSION['nombreAdmin'] ?? 'Administradora'); ?></strong>!</p>
        <div class="usuarioAdmin">
            <a href="perfilAdmin.php" class="btnUser">Mi perfil</a>
            <a href="logoutAdmin.php" class="btnUser btnLogout" onclick="return confirm('Vas a cerrar sesión y volverás a las secciones públicas de la web, saliendo del área de administración. ¡Podrás volver con tu usuario y contraseña siempre que lo necesites! Acepta si quieres salir, Cancela si olvidas algo que revisar en el panel de administración.');">Cerrar sesión</a>
        </div>
</div>
</aside>

<script src="<?php echo BASE_URL; ?>/interaccion.js"></script>
</body>
</html>