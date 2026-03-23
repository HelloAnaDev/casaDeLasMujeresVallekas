<?php
session_start();

if (!isset($_SESSION['idAdmin'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../config/config.php';

$pagina = 'adminMemorias'; 

include 'sidebarHeader.php'; 


$buscar = $_GET['buscar'] ?? '';

$sql = "SELECT 
            m.idMemoria, m.titulo, m.fecha, 
            a.nombre AS nombre_creadora,
            (SELECT rutaImagen FROM imagenes_memorias im WHERE im.idMemoria = m.idMemoria LIMIT 1) as foto_principal
        FROM memorias m
        LEFT JOIN administradoras a ON m.id_admin = a.idAdmin";

if (!empty($buscar)) {
    $sql .= " WHERE m.titulo LIKE :busq OR YEAR(m.fecha) LIKE :busq";
}

$sql .= " ORDER BY m.fecha DESC";

$stmt = $pdo->prepare($sql);
if (!empty($buscar)) {
    $stmt->execute(['busq' => "%$buscar%"]);
} else {
    $stmt->execute();
}
$memorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="panelPrincipalAdmin">
    
<?php if (isset($_GET['exito'])): ?>
    <div class="alerta alerta-exito">
        <i class='bx bx-check-circle'></i> ¡Memoria publicada con éxito!
    </div>
<?php endif; ?>

<?php if (isset($_GET['editado'])): ?>
    <div class="alerta alerta-info">
        <i class='bx bx-edit'></i> Los cambios se han guardado correctamente.
    </div>
<?php endif; ?>

<?php if (isset($_GET['borrado'])): ?>
    <div class="alerta alerta-error">
        <i class='bx bx-trash'></i> Memoria eliminada.
    </div>
<?php endif; ?>

    <header class="cabeceraControles">
        <a href="crearMemoriaAdmin.php" class="btnCrearGigante">+ Crear memoria</a>
        
        <form action="memoriasAdmin.php" method="GET" class="buscadorAdmin">
            <input type="text" name="buscar" placeholder="Buscar por título o año" value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
            <button type="submit" class="btnBuscar"><i class='bx bx-search'></i></button>
        </form>
    </header>

    <section class="listaMemorias">
        
        <?php 

        if (count($memorias) === 0) {
            echo "<p style='text-align:center; color:#666;'>Aún no hay memorias publicadas.</p>";
        } else {
            foreach ($memorias as $memoria) {
                
                $fechaFormateada = date('d-m-Y', strtotime($memoria['fecha']));
                
                $autora = $memoria['nombre_creadora'] ?? 'Casa de las Mujeres Vallekas';

                $rutaImagen = $memoria['foto_principal'] ? '../images/memorias/' . $memoria['foto_principal'] : 'https://placehold.co/150x150/5B3C68/FFF?text=Foto';

                ?>
                
                <article class="filaMemoria">
                    <div class="bloqueImagen">
                        <img src="<?= htmlspecialchars($rutaImagen) ?>" alt="Miniatura de <?= htmlspecialchars($memoria['titulo']) ?>">
                    </div>
                    
                    <div class="bloqueInfo">
                        <h2 class="tituloMemoriaAdmin"><?= htmlspecialchars($memoria['titulo']) ?></h2>
                        <p class="datosMemoriaAdmin">Publicado el: <?= $fechaFormateada ?> | Creado por: <?= htmlspecialchars($autora) ?></p>
                    </div>
                    
                    <div class="bloqueAcciones">
                            <a href="verMemoriaAdmin.php?id=<?= $memoria['idMemoria'] ?>" class="btnAccion btnVer">
                                <i class='bx bx-show'></i> Ver
                            </a>
                            
                            <a href="editarMemoriaAdmin.php?id=<?= $memoria['idMemoria'] ?>" class="btnAccion btnEditar">
                                <i class='bx bx-edit-alt'></i> Modificar
                            </a>
                            
                            <a href="borrarMemoriaAdmin.php?id=<?= $memoria['idMemoria'] ?>" 
                            class="btnAccion btnBorrar" 
                            onclick="return confirm('¿Estás segura de que quieres borrar esta memoria?')">
                                <i class='bx bx-trash'></i> Borrar
                            </a>
                        </div>
                </article>

                <?php 
            } 
        } 
        ?>

    </section>
</main>

</body>
</html>