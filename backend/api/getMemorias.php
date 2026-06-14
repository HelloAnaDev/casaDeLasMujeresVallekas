<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../../config/config.php'; 

// Captura y saneamiento de parámetros de paginación y filtrado
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$texto = isset($_GET['texto']) ? trim($_GET['texto']) : '';
$categoria = isset($_GET['categoria']) ? trim($_GET['categoria']) : 'TODO';

$limit = 6; // Cargamos de 6 en 6 tarjetas
$offset = ($page - 1) * $limit;

try {
    // Construcción dinámica de condiciones de filtrado
    $where = "WHERE m.es_borrador = 0";
    $params = [];

    if (!empty($texto)) {
        $where .= " AND (m.titulo LIKE :texto OR m.descripcion LIKE :texto)";
        $params[':texto'] = "%$texto%";
    }

    if ($categoria !== 'TODO') {
        $where .= " AND m.categoria = :categoria";
        $params[':categoria'] = $categoria;
    }

    // 1. Obtener el número total de ítems bajo estos filtros (indispensable para el botón)
    $sqlCount = "SELECT COUNT(DISTINCT m.idMemoria) FROM memorias m $where";
    $stmtCount = $pdo->prepare($sqlCount);
    foreach ($params as $key => $val) {
        $stmtCount->bindValue($key, $val);
    }
    $stmtCount->execute();
    $totalItems = (int)$stmtCount->fetchColumn();

    // 2. Consulta paginada de memorias utilizando enlaces tipados para enteros en PDO
    $sql = "SELECT 
                m.idMemoria,
                m.titulo, 
                m.descripcion,
                m.fecha,
                m.categoria,
                m.likes,
                GROUP_CONCAT(i.rutaImagen) AS galeria_fotos
            FROM memorias m
            LEFT JOIN imagenes_memorias i ON m.idMemoria = i.idMemoria
            $where
            GROUP BY m.idMemoria
            ORDER BY m.fecha DESC
            LIMIT :limit OFFSET :offset";
            
    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $memorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Cargar comentarios únicamente de las memorias del bloque actual
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

    // Devolvemos la estructura con metadatos de control
    echo json_encode([
        'data' => $memorias,
        'total' => $totalItems,
        'limit' => $limit,
        'page' => $page
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Fallo SQL: " . $e->getMessage()]);
}
?>