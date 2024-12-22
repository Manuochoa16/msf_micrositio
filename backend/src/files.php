<?php
require_once 'db.php';

// Guardar información con archivos binarios
function saveInfo($name, $title = null, $subtitle = null, $description = null, $image = null, $audio = null, $video = null) {
    global $pdo;

    // Insertar la sección
    $stmt = $pdo->prepare("INSERT INTO sections (name) VALUES (?)");
    $stmt->execute([$name]);  // Usar el nombre recibido
    $section_id = $pdo->lastInsertId();

    // Insertar contenido solo si no es null
    if ($title) {
        $stmt = $pdo->prepare("INSERT INTO titles (section_id, title_text) VALUES (?, ?)");
        $stmt->execute([$section_id, $title]);
    }
    if ($subtitle) {
        $stmt = $pdo->prepare("INSERT INTO subtitles (title_id, subtitle_text) VALUES (?, ?)");
        $stmt->execute([$section_id, $subtitle]);
    }
    if ($description) {
        $stmt = $pdo->prepare("INSERT INTO paragraphs (title_id, paragraph_text) VALUES (?, ?)");
        $stmt->execute([$section_id, $description]);
    }

    // Procesar los archivos solo si están presentes
    if ($image) {
        $imagePath = saveFile($image, 'image');
        $stmt = $pdo->prepare("INSERT INTO media_files (title_id, file_type, file_path, file_size) VALUES (?, ?, ?, ?)");
        $stmt->execute([$section_id, 'image', $imagePath, filesize($image['tmp_name'])]);
    }
    if ($audio) {
        $audioPath = saveFile($audio, 'audio');
        $stmt = $pdo->prepare("INSERT INTO media_files (title_id, file_type, file_path, file_size) VALUES (?, ?, ?, ?)");
        $stmt->execute([$section_id, 'audio', $audioPath, filesize($audio['tmp_name'])]);
    }
    if ($video) {
        $videoPath = saveFile($video, 'video');
        $stmt = $pdo->prepare("INSERT INTO media_files (title_id, file_type, file_path, file_size) VALUES (?, ?, ?, ?)");
        $stmt->execute([$section_id, 'video', $videoPath, filesize($video['tmp_name'])]);
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
    return $result ?: ['error' => 'No se encontraron secciones.'];
}

// Función para crear una nueva sección
function createSection($name) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO sections (name) VALUES (?)");
    $stmt->execute([$name]);
    return $pdo->lastInsertId();
}
?>
