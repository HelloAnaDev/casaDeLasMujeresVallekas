<?php
require_once '../config/db.php';

$idImg = $_GET['idImg'] ?? null;
$idMem = $_GET['idMem'] ?? null;

if ($idImg && $idMem) {
    try {
        $stmt = $pdo->prepare("SELECT rutaImagen FROM imagenes_memorias WHERE idImagen = ?");
        $stmt->execute([$idImg]);
        $foto = $stmt->fetch();

        if ($foto) {
            $rutaFisica = "../images/memorias/" . $foto['rutaImagen'];
            
            if (file_exists($rutaFisica)) {
                unlink($rutaFisica);
            }

            $stmtDel = $pdo->prepare("DELETE FROM imagenes_memorias WHERE idImagen = ?");
            $stmtDel->execute([$idImg]);
        }

        header("Location: editarMemoriaAdmin.php?id=" . $idMem . "&fotoBorrada=1");
        exit;

    } catch (Exception $e) {
        die("Error al eliminar la foto: " . $e->getMessage());
    }
}