<?php
require_once 'db.php';

// Guardar información con archivos binarios
function saveInfo($sectionId, $name, $title = null, $subtitle = null, $description = null, $image = null, $audio = null, $video = null) {
    global $pdo;

    try {
        // Insertar el nombre de la sección
        $stmt = $pdo->prepare("INSERT INTO sections (name) VALUES (?)");
        $stmt->execute([$name]);
        $section_id = $pdo->lastInsertId(); // Usar section_id que viene desde la llamada
        
        // Insertar el título y obtener su ID
        $title_id = null;
        if ($title) {
            $stmt = $pdo->prepare("INSERT INTO titles (section_id, title_text) VALUES (?, ?)");
            $stmt->execute([$sectionId, $title]); // Usamos el section_id aquí
            $title_id = $pdo->lastInsertId(); // Obtener el ID del título insertado
        }

        // Insertar subtítulos solo si hay un título
        if ($subtitle && $title_id) {
            $stmt = $pdo->prepare("INSERT INTO subtitles (title_id, subtitle_text) VALUES (?, ?)");
            $stmt->execute([$title_id, $subtitle]);
        }

        // Insertar descripción si está presente
        if ($description && $title_id) {
            $stmt = $pdo->prepare("INSERT INTO paragraphs (title_id, paragraph_text) VALUES (?, ?)");
            $stmt->execute([$title_id, $description]);
        }

        // Guardar archivos si están presentes
        if ($image) {
            saveFileToDatabase($title_id, 'image', $image);
        }
        if ($audio) {
            saveFileToDatabase($title_id, 'audio', $audio);
        }
        if ($video) {
            saveFileToDatabase($title_id, 'video', $video);
        }

        echo json_encode(['message' => 'Información guardada exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}


function saveFileToDatabase($title_id, $type, $file) {
    global $pdo;

    try {
        $fileData = file_get_contents($file['tmp_name']);
        $fileSize = filesize($file['tmp_name']);
        $fileMime = mime_content_type($file['tmp_name']);

        $stmt = $pdo->prepare("INSERT INTO media_files (title_id, file_type, file_data, file_size, file_mime) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title_id, $type, $fileData, $fileSize, $fileMime]);
    } catch (Exception $e) {
        throw new Exception("Error al guardar el archivo en la base de datos: " . $e->getMessage());
    }
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

function createTitle($section_id, $title) {
    global $pdo;

    // Insertar el título en la tabla titles
    $stmt = $pdo->prepare("INSERT INTO titles (section_id, title_text) VALUES (?, ?)");
    $stmt->execute([$section_id, $title]);

    // Obtener el ID del título insertado
    return $pdo->lastInsertId();
}

// Obtener información por ID
function getInfoById($id) {
    global $pdo;

    // Consultar la información de la sección
    $stmt = $pdo->prepare("SELECT * FROM sections WHERE id = ?");
    $stmt->execute([$id]);
    $section = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($section) {
        // Consultar los títulos de la sección
        $stmt = $pdo->prepare("SELECT * FROM titles WHERE section_id = ?");
        $stmt->execute([$id]);
        $titles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $section['titles'] = $titles;

        // Consultar los subtítulos de cada título
        foreach ($titles as &$title) {
            $stmt = $pdo->prepare("SELECT * FROM subtitles WHERE title_id = ?");
            $stmt->execute([$title['id']]);
            $subtitles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $title['subtitles'] = $subtitles;
        }

        // Consultar los párrafos de cada título
        foreach ($titles as &$title) {
            $stmt = $pdo->prepare("SELECT * FROM paragraphs WHERE title_id = ?");
            $stmt->execute([$title['id']]);
            $paragraphs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $title['paragraphs'] = $paragraphs;
        }

        // Consultar los archivos multimedia
        foreach ($titles as &$title) {
            $stmt = $pdo->prepare("SELECT * FROM media_files WHERE title_id = ?");
            $stmt->execute([$title['id']]);
            $mediaFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $title['media_files'] = $mediaFiles;
        }

        return $section;
    } else {
        return null;  // No se encuentra la sección
    }
}

?>
