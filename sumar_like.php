<?php
require_once 'config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$accion = $data['accion'] ?? 'like'; // Recibimos si es 'like' o 'unlike'

if ($id) {
    try {
        if ($accion === 'unlike') {
            // Restamos 1, pero evitamos que baje de 0
            $sql = "UPDATE memorias SET likes = GREATEST(0, likes - 1) WHERE idMemoria = ?";
        } else {
            // Sumamos 1
            $sql = "UPDATE memorias SET likes = likes + 1 WHERE idMemoria = ?";
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Leemos el nuevo total
        $sql2 = "SELECT likes FROM memorias WHERE idMemoria = ?";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$id]);
        $nuevoTotal = $stmt2->fetchColumn();

        echo json_encode(['status' => 'success', 'likes' => $nuevoTotal]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
}
?>