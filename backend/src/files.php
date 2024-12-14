<?php 
require_once 'db.php';

// Guardar información con archivos binarios
function saveInfo($title, $subtitle, $description, $image, $audio, $video) {
    global $pdo;

    // Verifica los datos recibidos
    $title = $_POST['title'] ?? null;
    $subtitle = $_POST['subtitle'] ?? null;
    $description = $_POST['description'] ?? null;

    // Verifica los archivos
    $imageContent = isset($_FILES['image']['tmp_name']) && is_uploaded_file($_FILES['image']['tmp_name']) ? file_get_contents($_FILES['image']['tmp_name']) : null;
    $audioContent = isset($_FILES['audio']['tmp_name']) && is_uploaded_file($_FILES['audio']['tmp_name']) ? file_get_contents($_FILES['audio']['tmp_name']) : null;
    $videoContent = isset($_FILES['video']['tmp_name']) && is_uploaded_file($_FILES['video']['tmp_name']) ? file_get_contents($_FILES['video']['tmp_name']) : null;

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
        error_log(json_encode($stmt->errorInfo()));
        echo json_encode(['error' => 'Error de base de datos', 'details' => $stmt->errorInfo()]);
        return false;
    }

    echo json_encode(['message' => 'Información guardada exitosamente.']);
    return true;
}


// Obtener toda la información
function getInfo() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM info ORDER BY created_at DESC");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Procesar imágenes y otros archivos para enviarlos en base64
    foreach ($result as &$row) {
        $row['image'] = $row['image'] ? base64_encode($row['image']) : null;
        $row['audio'] = $row['audio'] ? base64_encode($row['audio']) : null;
        $row['video'] = $row['video'] ? base64_encode($row['video']) : null;
    }

    return $result ?: ['error' => 'No se encontraron registros.'];
}

// Actualizar la información existente
function updateInfo($id, $title, $subtitle, $description, $image, $audio, $video) {
    global $pdo;

    $imageContent = isset($image['tmp_name']) && is_uploaded_file($image['tmp_name']) ? file_get_contents($image['tmp_name']) : null;
    $audioContent = isset($audio['tmp_name']) && is_uploaded_file($audio['tmp_name']) ? file_get_contents($audio['tmp_name']) : null;
    $videoContent = isset($video['tmp_name']) && is_uploaded_file($video['tmp_name']) ? file_get_contents($video['tmp_name']) : null;

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
