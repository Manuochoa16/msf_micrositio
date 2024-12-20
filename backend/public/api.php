<?php
require_once '../src/auth.php';
require_once '../src/files.php';

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173'); // Cambia este puerto si tu frontend usa otro
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

// Aquí pondremos la clave secreta del reCAPTCHA
$recaptchaSecret = 'TU_CLAVE_SECRETA_DE_RECAPTCHA';

try {
    switch ($endpoint) {
        // Endpoint de login
        case 'login':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                
                if (empty($data['username']) || empty($data['password'])) {
                    throw new Exception('Los campos username y password son obligatorios.');
                }

                // Verificar reCAPTCHA
                $recaptchaResponse = $data['recaptcha'];
                if (empty($recaptchaResponse)) {
                    throw new Exception('reCAPTCHA es obligatorio.');
                }
                
                // Verificación del reCAPTCHA
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
                if (registerUser($data['username'], $data['password'])) {
                    echo json_encode(['message' => 'Usuario registrado exitosamente.']);
                } else {
                    throw new Exception('No se pudo registrar el usuario. Es posible que el nombre de usuario ya exista.');
                }
            }
            break;

        case 'getInfo':
            if ($method === 'GET') {
                $data = getInfo();
                echo json_encode($data);
            }
            break;

        case 'saveInfo':
            if ($method === 'POST') {
                $data = $_POST;

                // Los campos título, subtítulo y descripción ya no son obligatorios
                $title = $data['title'] ?? null;
                $subtitle = $data['subtitle'] ?? null;
                $description = $data['description'] ?? null;

                $image = $_FILES['image'] ?? null;
                $audio = $_FILES['audio'] ?? null;
                $video = $_FILES['video'] ?? null;

                if (saveInfo($title, $subtitle, $description, $image, $audio, $video)) {
                    echo json_encode(['message' => 'Información guardada exitosamente.']);
                } else {
                    throw new Exception('No se pudo guardar la información.');
                }
            }
            break;

        case 'updateInfo':
            if ($method === 'POST') {
                $data = $_POST;

                // Verificación de los campos obligatorios
                if (empty($data['id'])) {
                    throw new Exception('El campo id es obligatorio.');
                }

                // Los campos título, subtítulo y descripción ya no son obligatorios
                $title = $data['title'] ?? null;
                $subtitle = $data['subtitle'] ?? null;
                $description = $data['description'] ?? null;

                $image = $_FILES['image'] ?? null;
                $audio = $_FILES['audio'] ?? null;
                $video = $_FILES['video'] ?? null;

                if (updateInfo($data['id'], $title, $subtitle, $description, $image, $audio, $video)) {
                    echo json_encode(['message' => 'Información actualizada exitosamente.']);
                } else {
                    throw new Exception('No se pudo actualizar la información.');
                }
            }
            break;

        case 'getInfoById':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);

                if (empty($data['id'])) {
                    throw new Exception('El campo id es obligatorio.');
                }

                $info = getInfoById($data['id']);

                if ($info) {
                    $info['image_mime'] = $info['image'] ? 'image/jpeg' : null;
                    $info['audio_mime'] = $info['audio'] ? 'audio/mpeg' : null;
                    $info['video_mime'] = $info['video'] ? 'video/mp4' : null;

                    echo json_encode($info);
                } else {
                    throw new Exception('No se encontró información para el ID proporcionado.');
                }
            }
            break;
            case 'createSection':
                if ($method === 'POST') {
                    $data = json_decode(file_get_contents('php://input'), true);
            
                    if (empty($data['name'])) {
                        throw new Exception('El campo name es obligatorio.');
                    }
            
                    $sectionId = createSection($data['name']);
                    if ($sectionId) {
                        echo json_encode(['message' => 'Sección creada exitosamente.', 'section_id' => $sectionId]);
                    } else {
                        throw new Exception('No se pudo crear la sección.');
                    }
                }
                break;
            

        default:
            throw new Exception('Endpoint no válido.');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
