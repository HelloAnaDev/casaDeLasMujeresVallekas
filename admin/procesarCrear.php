<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $fecha = $_POST['fecha'] ?? date('Y-m-d');
    $descripcion = $_POST['descripcion'] ?? '';
    $id_admin = null; 

    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO memorias (titulo, fecha, descripcion, id_admin) VALUES (:t, :f, :d, :a)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['t' => $titulo, 'f' => $fecha, 'd' => $descripcion, 'a' => $id_admin]);
        
        $idMemoria = $pdo->lastInsertId();

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
        header("Location: memoriasAdmin.php?exito=1");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error crítico: " . $e->getMessage());
    }
}