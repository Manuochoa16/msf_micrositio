<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadBaseDir = '../uploads/'; // Directorio base para subidas
    $file = $_FILES['file'];
    $fileType = mime_content_type($file['tmp_name']); // Detecta el tipo MIME del archivo
    $subDir = ''; // Subdirectorio basado en el tipo de archivo

    // Determina el subdirectorio según el tipo de archivo
    if (strpos($fileType, 'image') !== false) {
        $subDir = 'images/';
    } elseif (strpos($fileType, 'video') !== false) {
        $subDir = 'videos/';
    } elseif (strpos($fileType, 'application') !== false || strpos($fileType, 'text') !== false) {
        $subDir = 'docs/';
    } else {
        echo "<h1>Tipo de archivo no soportado</h1>";
        exit;
    }

    $uploadDir = $uploadBaseDir . $subDir;

    // Verifica si la carpeta de destino existe, si no, la crea
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . basename($file['name']);

    try {
        // Mueve el archivo subido al directorio correspondiente
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            echo "<h1>Archivo subido exitosamente</h1>";
            echo "<p>Ruta del archivo: <a href='" . htmlspecialchars($filePath) . "'>" . htmlspecialchars($filePath) . "</a></p>";
            if (strpos($fileType, 'image') !== false) {
                echo "<img src='" . htmlspecialchars($filePath) . "' alt='Archivo Subido' style='max-width: 500px;'>";
            } elseif (strpos($fileType, 'video') !== false) {
                echo "<video controls style='max-width: 500px;'>
                        <source src='" . htmlspecialchars($filePath) . "' type='" . htmlspecialchars($fileType) . "'>
                      </video>";
            }
        } else {
            throw new Exception("Error al mover el archivo al directorio de destino.");
        }
    } catch (Exception $e) {
        echo "<h1>Error al subir el archivo</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
} else {
    echo "<h1>No se recibió ningún archivo</h1>";
}
?>
