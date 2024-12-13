<?php
// Redirige al frontend si está separado
header('Content-Type: application/json');
echo json_encode([
    'message' => 'Bienvenido al backend del proyecto MSF. Utiliza los endpoints de la API para interactuar con el sistema.',
    'endpoints' => [
        'POST /api.php?endpoint=register' => 'Registrar un nuevo usuario',
        'POST /api.php?endpoint=login' => 'Iniciar sesión',
        'GET /api.php?endpoint=getFiles' => 'Obtener todos los archivos',
        'POST /api.php?endpoint=saveFile' => 'Guardar un nuevo archivo',
        'PUT /api.php?endpoint=updateFile' => 'Actualizar un archivo existente',
    ]
]);
exit;