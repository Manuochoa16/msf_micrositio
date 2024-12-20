<?php
require_once 'db.php';

// Guardar información con archivos binarios
function saveInfo($section_id, $title = null, $subtitle = null, $description = null, $image = null, $audio = null, $video = null) {
    global $pdo;

    // Validar que section_id no esté vacío
    if (empty($section_id)) {
        echo json_encode(['error' => 'section_id es obligatorio.']);
        return;
    }

    // Insertar la ancla
    $stmt = $pdo->prepare("INSERT INTO anchors (section_id, name) VALUES (?, ?)");
    $stmt->execute([$section_id, $title ?? '']); // Se usa un valor vacío si el título es null
    $anchor_id = $pdo->lastInsertId();

    // Insertar contenido solo si no es null
    if ($title) {
        $stmt = $pdo->prepare("INSERT INTO contents (anchor_id, type, content) VALUES (?, ?, ?)");
        $stmt->execute([$anchor_id, 'title', $title]);
    }
    if ($subtitle) {
        $stmt = $pdo->prepare("INSERT INTO contents (anchor_id, type, content) VALUES (?, ?, ?)");
        $stmt->execute([$anchor_id, 'subtitle', $subtitle]);
    }
    if ($description) {
        $stmt = $pdo->prepare("INSERT INTO contents (anchor_id, type, content) VALUES (?, ?, ?)");
        $stmt->execute([$anchor_id, 'description', $description]);
    }

    // Procesar los archivos solo si están presentes
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

function getInfoById($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM sections WHERE id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result;
    } else {
        throw new Exception('No se encontró información para el ID proporcionado.');
    }
}

function createSection($name) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO sections (name) VALUES (?)");
    if ($stmt->execute([$name])) {
        return $pdo->lastInsertId(); // Devuelve el ID de la nueva sección
    }
    return false; // Fallo en la creación
}
?>
