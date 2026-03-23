<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idMemoria = $_POST['idMemoria'] ?? null;
    $titulo = $_POST['titulo'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';

    if (!$idMemoria) {
        header("Location: memoriasAdmin.php");
        exit;
    }

    try {
        $pdo->beginTransaction();

        $sql = "UPDATE memorias SET titulo = :t, fecha = :f, descripcion = :d WHERE idMemoria = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            't' => $titulo,
            'f' => $fecha,
            'd' => $descripcion,
            'id' => $idMemoria
        ]);

        if (!empty($_FILES['imagenes']['name'][0])) {
            foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                $nombreOriginal = $_FILES['imagenes']['name'][$key];
                $nombreFinal = time() . "_" . $nombreOriginal;
                $rutaDestino = "../images/memorias/" . $nombreFinal;

                if (move_uploaded_file($tmp_name, $rutaDestino)) {
                    $sqlImg = "INSERT INTO imagenes_memorias (idMemoria, rutaImagen) VALUES (?, ?)";
                    $pdo->prepare($sqlImg)->execute([$idMemoria, $nombreFinal]);
                }
            }
        }

        $pdo->commit();
        header("Location: memoriasAdmin.php?editado=1");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error al actualizar la memoria: " . $e->getMessage());
    }
} else {
    header("Location: memoriasAdmin.php");
    exit;
}