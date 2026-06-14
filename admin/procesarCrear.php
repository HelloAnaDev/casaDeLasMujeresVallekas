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
    $categoria = $_POST['categoria'] ?? 'LA CASA';
    $es_borrador = (isset($_POST['accion']) && $_POST['accion'] === 'borrador') ? 1 : 0;
    
    $id_admin = $_SESSION['idAdmin'];

    function convertirAWebp($rutaTemporal, $rutaDestinoFinal, $calidad = 80, $anchoMaximo = 1200) {
        $info = @getimagesize($rutaTemporal);
        if ($info === false) return false;
        
        $mime = $info['mime'];
        $anchoOriginal = $info[0];
        $altoOriginal = $info[1];
        
        // 1. Cargar la imagen en memoria según su formato
        if ($mime == 'image/jpeg') {
            $imgOriginal = imagecreatefromjpeg($rutaTemporal);
        } elseif ($mime == 'image/png') {
            $imgOriginal = imagecreatefrompng($rutaTemporal);
        } elseif ($mime == 'image/webp') {
            $imgOriginal = imagecreatefromwebp($rutaTemporal);
        } else {
            return false;
        }

        if (!$imgOriginal) return false;

        // 2. Si la imagen es más grande que nuestro límite, la redimensionamos
        if ($anchoOriginal > $anchoMaximo) {
            $altoNuevo = ($anchoMaximo / $anchoOriginal) * $altoOriginal;
            $anchoNuevo = $anchoMaximo;

            $imgFinal = imagecreatetruecolor($anchoNuevo, $altoNuevo);

            // Preservar transparencias si era PNG
            if ($mime == 'image/png') {
                imagealphablending($imgFinal, false);
                imagesavealpha($imgFinal, true);
                $transparente = imagecolorallocatealpha($imgFinal, 255, 255, 255, 127);
                imagefilledrectangle($imgFinal, 0, 0, $anchoNuevo, $altoNuevo, $transparente);
            }

            imagecopyresampled($imgFinal, $imgOriginal, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $anchoOriginal, $altoOriginal);
            
            $exito = imagewebp($imgFinal, $rutaDestinoFinal, $calidad);
            imagedestroy($imgFinal);
            
        } else {
            // 3. Si la imagen ya es pequeña, solo la pasamos a WebP directamente
            if ($mime == 'image/png') {
                imagepalettetotruecolor($imgOriginal);
                imagealphablending($imgOriginal, true);
                imagesavealpha($imgOriginal, true);
            }
            $exito = imagewebp($imgOriginal, $rutaDestinoFinal, $calidad);
        }

        imagedestroy($imgOriginal);
        return $exito;
    }

    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO memorias (titulo, fecha, descripcion, id_admin, categoria, es_borrador) VALUES (:t, :f, :d, :a, :c, :b)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['t' => $titulo, 'f' => $fecha, 'd' => $descripcion, 'a' => $id_admin, 'c' => $categoria, 'b' => $es_borrador]);
        
        $idMemoria = $pdo->lastInsertId();

        if (!empty($_FILES['imagenes']['name'][0])) {
            foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                // Filtro de seguridad: saltar si hubo error en la subida de este archivo concreto
                if ($_FILES['imagenes']['error'][$key] !== UPLOAD_ERR_OK) continue;

                // Forzamos el nombre limpio y la extensión .webp
                $nombreFinal = uniqid('img_') . "_" . time() . ".webp";
                $rutaDestino = "../images/memorias/" . $nombreFinal;

                // Usamos nuestra función optimizada
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
?>