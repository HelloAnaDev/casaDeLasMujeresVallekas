<?php
session_start(); 

if (!isset($_SESSION['idAdmin'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $fecha = $_POST['fecha'] ?? date('Y-m-d');
    $descripcion = $_POST['descripcion'] ?? '';
    
    $id_admin = $_SESSION['idAdmin']; 

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

        $sql = "INSERT INTO memorias (titulo, fecha, descripcion, id_admin) VALUES (:t, :f, :d, :a)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['t' => $titulo, 'f' => $fecha, 'd' => $descripcion, 'a' => $id_admin]);
        
        $idMemoria = $pdo->lastInsertId();

    if (!empty($_FILES['imagenes']['name'][0])) {
                foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                    // Filtro de seguridad: saltar si hubo error en la subida de este archivo concreto
                    if ($_FILES['imagenes']['error'][$key] !== UPLOAD_ERR_OK) continue;

                    // Forzamos el nombre limpio y la extensión .webp
                    $nombreFinal = uniqid('img_') . "_" . time() . ".webp";
                    $rutaDestino = "../images/memorias/" . $nombreFinal;

                    // Usamos nuestra función en lugar de move_uploaded_file
                    if (convertirAWebp($tmp_name, $rutaDestino, 80)) {
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