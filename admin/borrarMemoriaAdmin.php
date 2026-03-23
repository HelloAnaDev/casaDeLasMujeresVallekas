<?php
require_once '../config/db.php';

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    try {
        $sqlFotos = "SELECT rutaImagen FROM imagenes_memorias WHERE idMemoria = :id";
        $stmtFotos = $pdo->prepare($sqlFotos);
        $stmtFotos->execute(['id' => $id]);
        $fotos = $stmtFotos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($fotos as $foto) {
            $rutaFisica = "../images/memorias/" . $foto['rutaImagen'];
            if (file_exists($rutaFisica)) {
                unlink($rutaFisica); 
            }
        }

        $sqlBorrar = "DELETE FROM memorias WHERE idMemoria = :id";
        $stmtBorrar = $pdo->prepare($sqlBorrar);
        $stmtBorrar->execute(['id' => $id]);

        header("Location: memoriasAdmin.php?borrado=1");
        exit;

    } catch (Exception $e) {
        die("Error al borrar: " . $e->getMessage());
    }
} else {
    header("Location: memoriasAdmin.php");
    exit;
}