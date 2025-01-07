<?php
require_once 'db.php';

// Guardar información con archivos binarios
// Crear sección
function createSection($name) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO sections (name, is_visible) VALUES (?, ?)");
    $stmt->execute([$name, true]); // is_visible por defecto en true
    return $pdo->lastInsertId();
}


// Obtener información por ID
// Crear título
function createTitle($section_id, $title) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO titles (section_id, title_text, is_visible) VALUES (?, ?, ?)");
    $stmt->execute([$section_id, $title, true]); // is_visible por defecto en true
    return $pdo->lastInsertId();
}

// Guardar subtítulos
function addSubtitle($title_id, $subtitle) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO subtitles (title_id, subtitle_text, is_visible) VALUES (?, ?, ?)");
    $stmt->execute([$title_id, $subtitle, true]);
}

// Agregar descripción
function addDescription($title_id, $description) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO paragraphs (title_id, paragraph_text, is_visible) VALUES (?, ?, ?)");
    $stmt->execute([$title_id, $description, true]);
}

// Guardar archivo en base de datos (audio, imagen, video)
// Agregar validaciones adicionales para el archivo
function saveFileToDatabase($title_id, $type, $file) {
    global $pdo;

    // Validaciones de tipo y tamaño de archivo
    $allowedTypes = ['image' => ['image/jpeg', 'image/png'], 'audio' => ['audio/mpeg', 'audio/wav'], 'video' => ['video/mp4']];
    if (!in_array($file['type'], $allowedTypes[$type])) {
        throw new Exception('Tipo de archivo no permitido.');
    }

    // Tamaño máximo permitido (Ejemplo: 10MB)
    $maxSize = 10 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        throw new Exception('El archivo excede el tamaño máximo permitido.');
    }

    try {
        $fileData = file_get_contents($file['tmp_name']);
        $fileSize = filesize($file['tmp_name']);
        $fileMime = mime_content_type($file['tmp_name']);
        $stmt = $pdo->prepare("INSERT INTO media_files (title_id, file_type, file_data, file_size, file_mime, is_visible) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title_id, $type, $fileData, $fileSize, $fileMime, true]);
    } catch (Exception $e) {
        throw new Exception("Error al guardar el archivo: " . $e->getMessage());
    }
}


// Agregar imagen
function addImage($title_id, $image) {
    saveFileToDatabase($title_id, 'image', $image);
}

// Agregar audio
function addAudio($title_id, $audio) {
    saveFileToDatabase($title_id, 'audio', $audio);
}

// Agregar video
function addVideo($title_id, $video) {
    saveFileToDatabase($title_id, 'video', $video);
}
// Obtener todos los títulos y sus subtítulos, descripciones, imágenes, audios, videos
function getInfoById($id) {
    global $pdo;

    // Obtener sección por ID
    $stmt = $pdo->prepare("SELECT * FROM sections WHERE id = ?");
    $stmt->execute([$id]);
    $section = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($section) {
        // Obtener títulos relacionados a la sección
        $stmt = $pdo->prepare("SELECT * FROM titles WHERE section_id = ? AND is_visible = ?");
        $stmt->execute([$id, true]);
        $titles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agregar los subtítulos, descripciones, imágenes, audios, videos
        foreach ($titles as &$title) {
            $titleId = $title['id'];

            // Subtítulos
            $stmt = $pdo->prepare("SELECT * FROM subtitles WHERE title_id = ? AND is_visible = ?");
            $stmt->execute([$titleId, true]);
            $title['subtitles'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Descripción
            $stmt = $pdo->prepare("SELECT * FROM paragraphs WHERE title_id = ? AND is_visible = ?");
            $stmt->execute([$titleId, true]);
            $title['descriptions'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Archivos (imagenes, audios, videos)
            $stmt = $pdo->prepare("SELECT * FROM media_files WHERE title_id = ? AND is_visible = ?");
            $stmt->execute([$titleId, true]);
            $title['media_files'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return ['section' => $section, 'titles' => $titles];
    }

    return null;
}
// Modificar visibilidad de un título, subtítulo, descripción o archivo
function updateVisibility($id, $type, $is_visible) {
    global $pdo;

    $table = '';
    if ($type === 'title') {
        $table = 'titles';
    } elseif ($type === 'subtitle') {
        $table = 'subtitles';
    } elseif ($type === 'paragraph') {
        $table = 'paragraphs';
    } elseif ($type === 'media') {
        $table = 'media_files';
    }

    if ($table) {
        $stmt = $pdo->prepare("UPDATE $table SET is_visible = ? WHERE id = ?");
        $stmt->execute([$is_visible, $id]);
    }
}


?>
