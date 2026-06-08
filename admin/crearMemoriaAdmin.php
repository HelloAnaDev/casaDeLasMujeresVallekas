<?php 
session_start();

if (!isset($_SESSION['idAdmin'])) {
    header('Location: ../login.php');
    exit;
}
include 'sidebarHeader.php'; 
?>

<main class="panelPrincipalAdmin">
    
    <a href="memoriasAdmin.php" class="btnVolver">
        <i class='bx bx-arrow-back'></i> Cancelar y volver
    </a>

    <section class="contenedorFormulario">
        <h1 class="tituloSeccion">Nueva Memoria Mensual</h1>
        <p class="subtitulo">Registra las actividades, talleres y fotos del mes.</p>

        <form action="procesarCrear.php" method="POST" enctype="multipart/form-data" class="formularioAdmin">
            
            <div class="grupoInput">
                <label for="titulo">Título de la actividad / Mes</label>
                <input type="text" id="titulo" name="titulo" placeholder="Ej: Talleres Marzo 2026" required>
            </div>

            <div class="grupoInput">
                <label for="fecha">Fecha de publicación</label>
                <input type="date" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="grupoInput">
                <label for="categoria">Tipo de contenido</label>
                <select id="categoria" name="categoria" required style="padding: 12px 15px; border: 2px solid #eee; border-radius: 15px; font-family: inherit; font-size: 1rem; color: #333; outline: none; transition: border-color 0.2s;">
                    <option value="LA CASA">La Casa (Actividades y eventos)</option>
                    <option value="VARIOS">Lecturas (Artículos, reflexiones, etc.)</option>
                </select>
            </div>
            
            <div class="grupoInput">
                <label for="descripcion">Descripción de las actividades</label>
                <textarea id="descripcion" name="descripcion" rows="8" placeholder="Escribe aquí qué se hizo en la Casa este mes..." required></textarea>
            </div>

            <div class="grupoInput">
                <label for="fotos">Subir fotografías (Puedes seleccionar varias)</label>
                <input type="file" id="fotos" name="imagenes[]" accept="image/*" multiple class="inputFileCustom">
                <small>Formatos permitidos: JPG, PNG, WEBP.</small>
            </div>

            <div class="accionesForm">
                <button type="submit" class="btnGuardar">
                    <i class='bx bx-save'></i> Publicar Memoria
                </button>
            </div>

        </form>
    </section>
</main>

</body>
</html>