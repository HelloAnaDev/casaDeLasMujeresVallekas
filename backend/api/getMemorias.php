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

    foreach ($memorias as &$memoria) {
        if ($memoria['galeria_fotos'] !== null) {
            $memoria['galeria_fotos'] = explode(',', $memoria['galeria_fotos']);
        } else {
            $memoria['galeria_fotos'] = [];
        }
    }
    unset($memoria); 

    echo json_encode($memorias);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Fallo en la base de datos"]);
}