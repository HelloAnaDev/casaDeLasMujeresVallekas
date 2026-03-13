<?php 
include 'slidebar.php'; 
?>

<main class="contenedor-admin">
    <h1>Gestión de Agenda</h1>

    <?php if (isset($_GET['exito']) && $_GET['exito'] == '1'): ?>
        <div class="mensaje-exito">
            ¡Actividad guardada con éxito! 🎉
        </div>
    <?php endif; ?>

    <a href="crearActividad.php" class="btn-crear">
        Crear nueva actividad
    </a>

</main>

<?php include '../footer.php'; ?>
