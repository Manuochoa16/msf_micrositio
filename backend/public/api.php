<?php
require_once '../src/auth.php';
require_once '../src/files.php';

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');

// Manejo de las solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

$recaptchaSecret = '6LeDkKEqAAAAAIbOAk2Dl6NC6Tj5hr3q_0_hcB7q';

try {
    switch ($endpoint) {
        case 'login':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);

                if (empty($data['username']) || empty($data['password'])) {
                    throw new Exception('Los campos username y password son obligatorios.');
                }

                // Comentado: Verificación del reCAPTCHA
                /*
                $recaptchaResponse = $data['recaptcha'];
                if (empty($recaptchaResponse)) {
                    throw new Exception('reCAPTCHA es obligatorio.');
                }
                $recaptchaVerifyUrl = "https://www.google.com/recaptcha/api/siteverify";
                $recaptchaData = [
                    'secret' => $recaptchaSecret,
                    'response' => $recaptchaResponse
                ];
                $options = [
                    'http' => [
                        'method' => 'POST',
                        'content' => http_build_query($recaptchaData),
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                    ]
                ];
                $context = stream_context_create($options);
                $response = file_get_contents($recaptchaVerifyUrl, false, $context);
                $result = json_decode($response, true);
                if (!$result['success']) {
                    throw new Exception('Verificación de reCAPTCHA fallida.');
                }
                */

                // Login
                if ($user = loginUser($data['username'], $data['password'])) {
                    echo json_encode(['message' => 'Login exitoso.', 'user' => $user]);
                } else {
                    throw new Exception('Usuario o contraseña incorrectos.');
                }
            }
            break;

        case 'register':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);

                if (empty($data['username']) || empty($data['password'])) {
                    throw new Exception('Los campos username y password son obligatorios.');
                }

                // Comentado: Verificación del reCAPTCHA
                /*
                $recaptchaResponse = $data['recaptcha'];
                if (empty($recaptchaResponse)) {
                    throw new Exception('reCAPTCHA es obligatorio.');
                }
                $recaptchaVerifyUrl = "https://www.google.com/recaptcha/api/siteverify";
                $recaptchaData = [
                    'secret' => $recaptchaSecret,
                    'response' => $recaptchaResponse
                ];
                $options = [
                    'http' => [
                        'method' => 'POST',
                        'content' => http_build_query($recaptchaData),
                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                    ]
                ];
                $context = stream_context_create($options);
                $response = file_get_contents($recaptchaVerifyUrl, false, $context);
                $result = json_decode($response, true);
                if (!$result['success']) {
                    throw new Exception('Verificación de reCAPTCHA fallida.');
                }
                */

                if (registerUser($data['username'], $data['password'])) {
                    echo json_encode(['message' => 'Usuario registrado exitosamente.']);
                } else {
                    throw new Exception('No se pudo registrar el usuario. Es posible que el nombre de usuario ya exista.');
                }
            }
            break;

        // 1. Crear sección
        case 'createSection':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['name'])) {
                    throw new Exception('El campo "name" es obligatorio.');
                }
                $sectionId = createSection($data['name']);
                echo json_encode(['message' => 'Sección creada exitosamente.', 'section_id' => $sectionId]);
            }
            break;

        // 2. Modificar sección (PUT)
        case 'updateSection':
            if ($method === 'PUT') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['section_id']) || empty($data['name'])) {
                    throw new Exception('El campo "section_id" y "name" son obligatorios.');
                }
                $updated = updateSection($data['section_id'], $data['name']);
                echo json_encode(['message' => $updated ? 'Sección actualizada exitosamente.' : 'No se pudo actualizar la sección.']);
            }
            break;

        // 3. Obtener información de las secciones
        case 'getSections':
            if ($method === 'GET') {
                $sections = getSections(); // Obtener todas las secciones
                echo json_encode($sections);
            }
            break;

        // 4. Crear título
        case 'createTitle':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['title']) || empty($data['section_id'])) {
                    throw new Exception('El campo "title" y "section_id" son obligatorios.');
                }
                $titleId = createTitle($data['section_id'], $data['title']);
                echo json_encode(['message' => 'Título creado exitosamente.', 'title_id' => $titleId]);
            }
            break;

        // 5. Modificar título
        case 'updateTitle':
            if ($method === 'PUT') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['title_id']) || empty($data['title'])) {
                    throw new Exception('El campo "title_id" y "title" son obligatorios.');
                }
                function updateTitle($title_id, $title = null, $is_visible = null) {
                    global $pdo;
                
                    $fields = [];
                    $values = [];
                
                    if (!is_null($title)) {
                        $fields[] = "title = ?";
                        $values[] = $title;
                    }
                
                    if (!is_null($is_visible)) {
                        $fields[] = "is_visible = ?";
                        $values[] = $is_visible;
                    }
                
                    if (!empty($fields)) {
                        $values[] = $title_id;
                        $query = "UPDATE titles SET " . implode(", ", $fields) . " WHERE id = ?";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute($values);
                    }
                }
                $updated = updateTitle($data['title_id'], $data['title']);
                echo json_encode(['message' => $updated ? 'Título actualizado exitosamente.' : 'No se pudo actualizar el título.']);
            }
            break;

        // 6. Obtener información de los títulos
        case 'getTitles':
            if ($method === 'GET') {
                function getTitles() {
                    global $pdo;
                    $stmt = $pdo->query("SELECT * FROM titles");
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                $titles = getTitles();
                echo json_encode($titles);
            }
            break;

        // 7. Agregar subtítulo
        case 'addSubtitle':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['title_id']) || empty($data['subtitle'])) {
                    throw new Exception('El campo "title_id" y "subtitle" son obligatorios.');
                }
                $subtitleId = addSubtitle($data['title_id'], $data['subtitle']);
                echo json_encode(['message' => 'Subtítulo agregado exitosamente.', 'subtitle_id' => $subtitleId]);
            }
            break;

        // 8. Modificar subtítulo
        case 'updateSubtitle':
            if ($method === 'PUT') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['subtitle_id']) || empty($data['subtitle'])) {
                    throw new Exception('El campo "subtitle_id" y "subtitle" son obligatorios.');
                }
                $updated = updateSubtitle($data['subtitle_id'], $data['subtitle']);
                echo json_encode(['message' => $updated ? 'Subtítulo actualizado exitosamente.' : 'No se pudo actualizar el subtítulo.']);
            }
            break;

        // 9. Agregar descripción
        case 'addDescription':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['title_id']) || empty($data['description'])) {
                    throw new Exception('El campo "title_id" y "description" son obligatorios.');
                }
                $descriptionId = addDescription($data['title_id'], $data['description']);
                echo json_encode(['message' => 'Descripción agregada exitosamente.', 'description_id' => $descriptionId]);
            }
            break;

        // 10. Modificar descripción
        case 'updateDescription':
            if ($method === 'PUT') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['description_id']) || empty($data['description'])) {
                    throw new Exception('El campo "description_id" y "description" son obligatorios.');
                }
                $updated = updateDescription($data['description_id'], $data['description']);
                echo json_encode(['message' => $updated ? 'Descripción actualizada exitosamente.' : 'No se pudo actualizar la descripción.']);
            }
            break;

        // 11. Agregar audio
        case 'addAudio':
            if ($method === 'POST') {
                $data = $_POST;
                if (empty($data['title_id']) || empty($_FILES['audio'])) {
                    throw new Exception('El campo "title_id" y "audio" son obligatorios.');
                }
                $audioId = addAudio($data['title_id'], $_FILES['audio']);
                echo json_encode(['message' => 'Audio agregado exitosamente.', 'audio_id' => $audioId]);
            }
            break;

        // 12. Modificar audio
        case 'updateAudio':
            if ($method === 'PUT') {
                $data = $_POST;
                if (empty($data['audio_id']) || empty($_FILES['audio'])) {
                    throw new Exception('El campo "audio_id" y "audio" son obligatorios.');
                }
                $updated = updateAudio($data['audio_id'], $_FILES['audio']);
                echo json_encode(['message' => $updated ? 'Audio actualizado exitosamente.' : 'No se pudo actualizar el audio.']);
            }
            break;

        // 13. Agregar imagen
        case 'addImage':
            if ($method === 'POST') {
                $data = $_POST;
                if (empty($data['title_id']) || empty($_FILES['image'])) {
                    throw new Exception('El campo "title_id" y "image" son obligatorios.');
                }
                $imageId = addImage($data['title_id'], $_FILES['image']);
                echo json_encode(['message' => 'Imagen agregada exitosamente.', 'image_id' => $imageId]);
            }
            break;

        // 14. Modificar imagen
        case 'updateImage':
            if ($method === 'PUT') {
                $data = $_POST;
                if (empty($data['image_id']) || empty($_FILES['image'])) {
                    throw new Exception('El campo "image_id" y "image" son obligatorios.');
                }
                $updated = updateImage($data['image_id'], $_FILES['image']);
                echo json_encode(['message' => $updated ? 'Imagen actualizada exitosamente.' : 'No se pudo actualizar la imagen.']);
            }
            break;

        // 15. Eliminar imagen
        case 'deleteImage':
            if ($method === 'DELETE') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['image_id'])) {
                    throw new Exception('El campo "image_id" es obligatorio.');
                }
                $deleted = deleteImage($data['image_id']);
                echo json_encode(['message' => $deleted ? 'Imagen eliminada exitosamente.' : 'No se pudo eliminar la imagen.']);
            }
            break;

        // 16. Agregar video
        case 'addVideo':
            if ($method === 'POST') {
                $data = $_POST;
                if (empty($data['title_id']) || empty($_FILES['video'])) {
                    throw new Exception('El campo "title_id" y "video" son obligatorios.');
                }
                $videoId = addVideo($data['title_id'], $_FILES['video']);
                echo json_encode(['message' => 'Video agregado exitosamente.', 'video_id' => $videoId]);
            }
            break;

        // 17. Modificar video
        case 'updateVideo':
            if ($method === 'PUT') {
                $data = $_POST;
                if (empty($data['video_id']) || empty($_FILES['video'])) {
                    throw new Exception('El campo "video_id" y "video" son obligatorios.');
                }
                $updated = updateVideo($data['video_id'], $_FILES['video']);
                echo json_encode(['message' => $updated ? 'Video actualizado exitosamente.' : 'No se pudo actualizar el video.']);
            }
            break;

        // 18. Eliminar video
        case 'deleteVideo':
            if ($method === 'DELETE') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (empty($data['video_id'])) {
                    throw new Exception('El campo "video_id" es obligatorio.');
                }
                $deleted = deleteVideo($data['video_id']);
                echo json_encode(['message' => $deleted ? 'Video eliminado exitosamente.' : 'No se pudo eliminar el video.']);
            }
            break;

        default:
            throw new Exception("Endpoint no reconocido.");
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
