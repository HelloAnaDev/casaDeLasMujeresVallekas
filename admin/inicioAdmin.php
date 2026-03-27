<?php
session_start();

if (!isset($_SESSION['idAdmin'])) {
    header('Location: ../login.php');
    exit;
}

$pagina = 'inicioAdmin';
include 'sidebarHeader.php'; 
?>

<main class="contenedorAdmin">
    <h1 class="tituloAdmin">¡Hola, <?php echo htmlspecialchars($_SESSION['nombreAdmin']); ?>!</h1>
    <p class="subtituloAdmin">Bienvenida al panel de control de La Casa de Mujeres de Vallekas.</p>

    <div class="gridDashboard">
        <a href="comentariosAdmin.php" class="tarjetaDashboard">

            <h3>Moderar comentarios</h3>
            <p>Aprobar o rechazar los mensajes pendientes que nos hayan escrito en las memorias mesuales.</p>
        </a>

        <a href="crearMemoriaAdmin.php" class="tarjetaDashboard">
            <h3>Memorias de "La casa en marcha"</h3>
            <p>Crear, editar o eliminar las memorias mensuales publicadas en "La casa en marcha".</p>
        </a>

        <a href="contadorAdmin.php" class="tarjetaDashboard">
            <h3>Contador</h3>
            <p>Reiniciar el contador de días libres de feminicidios.</p>
        </a>

    </div>
</main>

