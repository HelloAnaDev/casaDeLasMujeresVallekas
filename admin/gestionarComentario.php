<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../config/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idComentario = $_POST['idComentario'] ?? null;
    $nuevoEstado = $_POST['nuevoEstado'] ?? null;

    if (!$idComentario || !$nuevoEstado) {
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos para procesar la petición.']);
        exit;
    }

    try {
        $sql = "UPDATE comentarios SET estadoPublicacion = :estado WHERE idComentario = :id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':estado' => $nuevoEstado,
            ':id' => $idComentario
        ]);

        echo json_encode(['status' => 'success']);

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la base de datos.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}