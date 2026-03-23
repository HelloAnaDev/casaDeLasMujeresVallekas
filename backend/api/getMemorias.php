<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../../config/config.php'; 

try {
    $sql = "SELECT 
                m.idMemoria,
                m.titulo, 
                m.descripcion,
                GROUP_CONCAT(i.rutaImagen) AS galeria_fotos
            FROM memorias m
            LEFT JOIN imagenes_memorias i ON m.idMemoria = i.idMemoria
            GROUP BY m.idMemoria";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $memorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlComentarios = "SELECT nombre, texto, fecha FROM comentarios WHERE idMemoria = ? AND estadoPublicacion = 1 ORDER BY fecha DESC";
    $stmtComentarios = $pdo->prepare($sqlComentarios);

    foreach ($memorias as &$memoria) {
        if ($memoria['galeria_fotos'] !== null) {
            $memoria['galeria_fotos'] = explode(',', $memoria['galeria_fotos']);
        } else {
            $memoria['galeria_fotos'] = [];
        }

        $stmtComentarios->execute([$memoria['idMemoria']]);
        $memoria['comentarios'] = $stmtComentarios->fetchAll(PDO::FETCH_ASSOC);

    }
    unset($memoria); 

    echo json_encode($memorias);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Fallo en la base de datos"]);
}
?>