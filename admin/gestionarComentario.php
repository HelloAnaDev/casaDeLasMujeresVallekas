<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idComentario = $_POST['idComentario'] ?? null;
    $accion = $_POST['nuevoEstado'] ?? null;

    if (!$idComentario || !$accion) {
        echo json_encode(['status' => 'error', 'message' => 'Faltan datos para procesar la petición.']);
        exit;
    }

    try {
        $pdo->beginTransaction();

        if ($accion === 'bloquear') {
            $stmtDev = $pdo->prepare("SELECT idDispositivo FROM comentarios WHERE idComentario = :id");
            $stmtDev->execute([':id' => $idComentario]);
            $idDispositivo = $stmtDev->fetchColumn();

            if ($idDispositivo) {
                $pdo->prepare("UPDATE comentaristas SET bloqueado = 1 WHERE idDispositivo = :idD")
                    ->execute([':idD' => $idDispositivo]);
            }
            
            $estadoFinal = 2; 
        } else {
            $estadoFinal = $accion;
        }

        $sql = "UPDATE comentarios SET estadoPublicacion = :estado WHERE idComentario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':estado' => $estadoFinal,
            ':id' => $idComentario
        ]);

        $pdo->commit();
        echo json_encode(['status' => 'success']);

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Error de base de datos.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
}