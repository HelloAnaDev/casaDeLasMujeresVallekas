<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../config/config.php'; 

try {
    $sql = "SELECT 
                c.idComentario, 
                c.nombre, 
                c.texto, 
                c.fecha, 
                m.titulo AS titulo_memoria 
            FROM comentarios c
            JOIN memorias m ON c.idMemoria = m.idMemoria
            WHERE c.estadoPublicacion = 0
            ORDER BY c.fecha ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $pendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($pendientes);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al recuperar comentarios pendientes"]);
}