<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idMemoria = $_POST['idMemoria'] ?? null;
    $titulo = $_POST['titulo'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $es_borrador = (isset($_POST['accion']) && $_POST['accion'] === 'borrador') ? 1 : 0;

if (!$idMemoria) {
        header("Location: memoriasAdmin.php");
        exit;
    }

    function convertirAWebp($rutaTemporal, $rutaDestinoFinal, $calidad = 80) {
        $info = @getimagesize($rutaTemporal);
        if ($info === false) return false;
        
        $mime = $info['mime'];
        
        if ($mime == 'image/jpeg') {
            $img = imagecreatefromjpeg($rutaTemporal);
        } elseif ($mime == 'image/png') {
            $img = imagecreatefrompng($rutaTemporal);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
        } elseif ($mime == 'image/webp') {
            return move_uploaded_file($rutaTemporal, $rutaDestinoFinal);
        } else {
            return false;
        }

        if (!$img) return false;
        $exito = imagewebp($img, $rutaDestinoFinal, $calidad);
        imagedestroy($img);
        return $exito;
    }

    try {
        $pdo->beginTransaction();

        $sql = "UPDATE memorias SET titulo = :t, fecha = :f, descripcion = :d, es_borrador = :b WHERE idMemoria = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            't' => $titulo,
            'f' => $fecha,
            'd' => $descripcion,
            'b' => $es_borrador,
            'id' => $idMemoria
        ]);

        if (!empty($_FILES['imagenes']['name'][0])) {
            foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['imagenes']['error'][$key] !== UPLOAD_ERR_OK) continue;

                $nombreFinal = uniqid('img_') . "_" . time() . ".webp";
                $rutaDestino = "../images/memorias/" . $nombreFinal;

                if (convertirAWebp($tmp_name, $rutaDestino, 80)) {
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