<?php
require '../vendor/autoload.php'; // Cargar autoload de Composer
require '../config/cloudinary_config.php'; // Configuración de Cloudinary

use Cloudinary\Api\Upload\UploadApi;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];

    try {
        $uploadResult = (new UploadApi())->upload($file, [
            'resource_type' => 'auto', // Detecta automáticamente si es imagen o video
        ]);

        echo "<h1>Archivo subido exitosamente</h1>";
        echo "<p>URL del archivo: <a href='" . $uploadResult['secure_url'] . "'>" . $uploadResult['secure_url'] . "</a></p>";
        echo "<img src='" . $uploadResult['secure_url'] . "' alt='Archivo Subido' style='max-width: 500px;'>";
    } catch (Exception $e) {
        echo "<h1>Error al subir el archivo</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
} else {
    echo "<h1>No se recibió ningún archivo</h1>";
}
?>
