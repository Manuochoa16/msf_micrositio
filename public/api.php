<?php
require_once '../src/auth.php';
require_once '../src/files.php';

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

try {
    switch ($endpoint) {
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

            case 'login':
                if ($method === 'POST') {
                    $data = json_decode(file_get_contents('php://input'), true);
                    if (empty($data['username']) || empty($data['password'])) {
                        throw new Exception('Los campos username y password son obligatorios.');
                    }
                    if ($user = loginUser($data['username'], $data['password'])) {
                        echo json_encode(['message' => 'Login exitoso.', 'user' => $user]);
                    } else {
                        throw new Exception('Usuario o contraseña incorrectos.');
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

                if (empty($data['title']) || empty($data['subtitle']) || empty($data['description'])) {
                    throw new Exception('Los campos título, subtítulo y descripción son obligatorios.');
                }

                $image = $_FILES['image'] ?? null;
                $audio = $_FILES['audio'] ?? null;
                $video = $_FILES['video'] ?? null;

                if (saveInfo($data['title'], $data['subtitle'], $data['description'], $image, $audio, $video)) {
                    echo json_encode(['message' => 'Información guardada exitosamente.']);
                } else {
                    throw new Exception('No se pudo guardar la información.');
                }
            }
            break;

        case 'updateInfo':
            if ($method === 'POST') {
                $data = $_POST;

                if (empty($data['id']) || empty($data['title']) || empty($data['subtitle']) || empty($data['description'])) {
                    throw new Exception('Faltan campos obligatorios.');
                }

                $image = $_FILES['image'] ?? null;
                $audio = $_FILES['audio'] ?? null;
                $video = $_FILES['video'] ?? null;

                if (updateInfo($data['id'], $data['title'], $data['subtitle'], $data['description'], $image, $audio, $video)) {
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

        default:
            throw new Exception('Endpoint no válido.');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
