<?php 
session_start();

if (!isset($_SESSION['idAdmin'])) {
    header('Location: ../login.php');
    exit;
}

$pagina = 'adminComentarios';
include 'sidebarHeader.php'; 
?>

<main class="contenedorAdmin">
    <h1 class="tituloAdmin">Moderación de comentarios</h1>
    <p class="subtituloAdmin">Revisa los mensajes pendientes antes de que se publiquen en la web.</p>

    <div id="listaPendientes" class="gridModeracion">
        <p class="cargando">Buscando comentarios pendientes...</p>
    </div>
</main>

<script src="moderacion.js"></script>


