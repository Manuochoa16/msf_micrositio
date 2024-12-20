<?php
require_once 'db.php';

// Guardar información con archivos binarios
function saveInfo($title, $subtitle, $description, $image, $audio, $video, $section_id) {
    global $pdo;

    // Insertar la ancla
    $stmt = $pdo->prepare("INSERT INTO anchors (section_id, name) VALUES (?, ?)");
    $stmt->execute([$section_id, $title]);
    $anchor_id = $pdo->lastInsertId();

    // Insertar contenido (por ejemplo, título, subtítulo, etc.)
    $stmt = $pdo->prepare("INSERT INTO contents (anchor_id, type, content) VALUES (?, ?, ?)");
    $stmt->execute([$anchor_id, 'title', $title]);
    $stmt->execute([$anchor_id, 'subtitle', $subtitle]);
    $stmt->execute([$anchor_id, 'description', $description]);

    // Procesar los archivos multimedia
    if ($image) {
        $imagePath = saveFile($image, 'image');
        $stmt = $pdo->prepare("INSERT INTO media_files (anchor_id, file_type, file_path, file_size) VALUES (?, ?, ?, ?)");
        $stmt->execute([$anchor_id, 'image', $imagePath, filesize($image['tmp_name'])]);
    }
    if ($audio) {
        $audioPath = saveFile($audio, 'audio');
        $stmt = $pdo->prepare("INSERT INTO media_files (anchor_id, file_type, file_path, file_size) VALUES (?, ?, ?, ?)");
        $stmt->execute([$anchor_id, 'audio', $audioPath, filesize($audio['tmp_name'])]);
    }
    if ($video) {
        $videoPath = saveFile($video, 'video');
        $stmt = $pdo->prepare("INSERT INTO media_files (anchor_id, file_type, file_path, file_size) VALUES (?, ?, ?, ?)");
        $stmt->execute([$anchor_id, 'video', $videoPath, filesize($video['tmp_name'])]);
    }

    echo json_encode(['message' => 'Información guardada exitosamente.']);
}

function saveFile($file, $type) {
    $targetDir = "uploads/" . $type . "/";
    $targetFile = $targetDir . basename($file["name"]);
    move_uploaded_file($file["tmp_name"], $targetFile);
    return $targetFile;
}

// Obtener toda la información
function getInfo() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM sections");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result ?: ['error' => 'No se encontraron registros.'];
}
?>
