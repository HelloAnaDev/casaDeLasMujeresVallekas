<?php
require_once '../config/db.php';

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    try {
        $pdo->beginTransaction();

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

        $sqlBorrarFotos = "DELETE FROM imagenes_memorias WHERE idMemoria = :id";
        $pdo->prepare($sqlBorrarFotos)->execute(['id' => $id]);

        $sqlBorrarComentarios = "DELETE FROM comentarios WHERE idMemoria = :id";
        $pdo->prepare($sqlBorrarComentarios)->execute(['id' => $id]);

        $sqlBorrarMemoria = "DELETE FROM memorias WHERE idMemoria = :id";
        $pdo->prepare($sqlBorrarMemoria)->execute(['id' => $id]);

        $pdo->commit();

        header("Location: memoriasAdmin.php?borrado=1");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack(); 
        die("Error crítico al borrar: " . $e->getMessage());
    }
} else {
    header("Location: memoriasAdmin.php");
    exit;
}