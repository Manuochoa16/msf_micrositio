<?php
require_once 'db.php';

// Guardar información con archivos binarios
function saveInfo($title, $subtitle, $description, $image, $audio, $video) {
    global $pdo;

    // Verifica si los archivos fueron enviados correctamente
    $imageContent = isset($image['tmp_name']) && $image['error'] === UPLOAD_ERR_OK ? file_get_contents($image['tmp_name']) : null;
    $audioContent = isset($audio['tmp_name']) && $audio['error'] === UPLOAD_ERR_OK ? file_get_contents($audio['tmp_name']) : null;
    $videoContent = isset($video['tmp_name']) && $video['error'] === UPLOAD_ERR_OK ? file_get_contents($video['tmp_name']) : null;

    // Inserta la información en la base de datos
    $stmt = $pdo->prepare("INSERT INTO info (title, subtitle, description, image, audio, video) VALUES (?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $title,
        $subtitle,
        $description,
        $imageContent,
        $audioContent,
        $videoContent
    ]);

    if (!$result) {
        // Registra el error en los logs
        error_log(json_encode($stmt->errorInfo()));
        echo json_encode(['error' => 'Error de base de datos', 'details' => $stmt->errorInfo()]);
    }

    return $result;
}

// Obtener toda la información
function getInfo() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM info ORDER BY created_at DESC");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result ?: ['error' => 'No se encontraron registros.'];
}

// Actualizar la información existente
function updateInfo($id, $title, $subtitle, $description, $image, $audio, $video) {
    global $pdo;

    $imageContent = isset($image['tmp_name']) && $image['error'] === UPLOAD_ERR_OK ? file_get_contents($image['tmp_name']) : null;
    $audioContent = isset($audio['tmp_name']) && $audio['error'] === UPLOAD_ERR_OK ? file_get_contents($audio['tmp_name']) : null;
    $videoContent = isset($video['tmp_name']) && $video['error'] === UPLOAD_ERR_OK ? file_get_contents($video['tmp_name']) : null;

    $stmt = $pdo->prepare("UPDATE info SET title = ?, subtitle = ?, description = ?, image = ?, audio = ?, video = ? WHERE id = ?");
    $result = $stmt->execute([
        $title,
        $subtitle,
        $description,
        $imageContent,
        $audioContent,
        $videoContent,
        $id
    ]);

    if (!$result) {
        error_log(json_encode($stmt->errorInfo()));
        echo json_encode(['error' => 'Error al actualizar los datos', 'details' => $stmt->errorInfo()]);
    }

    return $result;
}
// Obtener información por ID
function getInfoById($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM info WHERE id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        return null;
    }

    // Procesar los archivos binarios
    $result['image'] = $result['image'] ? base64_encode($result['image']) : null;
    $result['audio'] = $result['audio'] ? base64_encode($result['audio']) : null;
    $result['video'] = $result['video'] ? base64_encode($result['video']) : null;

    return $result;
}


?>
