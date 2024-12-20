<?php
// Redirige al frontend si está separado
header('Content-Type: application/json');
echo json_encode([
    'message' => 'Bienvenido al backend del proyecto MSF. Utiliza los endpoints de la API para interactuar con el sistema.',
    'endpoints' => [
        'POST /api.php?endpoint=login' => 'Iniciar sesión con reCAPTCHA. Requiere los campos username, password y recaptcha.',
        'POST /api.php?endpoint=register' => 'Registrar un nuevo usuario. Requiere los campos username y password.',
        'GET /api.php?endpoint=getInfo' => 'Obtener toda la información almacenada.',
        'POST /api.php?endpoint=saveInfo' => 'Guardar información con archivos binarios (títulos, subtítulos, descripciones, imágenes, audios, videos).',
        'POST /api.php?endpoint=updateInfo' => 'Actualizar información existente. Requiere el campo id y campos opcionales de título, subtítulo, descripción, imagen, audio, video.',
        'POST /api.php?endpoint=getInfoById' => 'Obtener información de una sección específica por ID. Requiere el campo id.',
        'POST /api.php?endpoint=createSection' => 'Crear una nueva sección. Requiere el campo name.',
    ]
]);
exit;
