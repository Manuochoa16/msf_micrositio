<?php
require_once '../src/auth.php';
require_once '../src/files.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

switch ($endpoint) {
    case 'register':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (registerUser($data['username'], $data['password'])) {
                echo json_encode(['message' => 'Usuario registrado exitosamente.']);
            } else {
                echo json_encode(['error' => 'No se pudo registrar el usuario.']);
            }
        }
        break;

    case 'login':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if ($user = loginUser($data['username'], $data['password'])) {
                echo json_encode(['message' => 'Login exitoso.', 'user' => $user]);
            } else {
                echo json_encode(['error' => 'Usuario o contraseña incorrectos.']);
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
                echo json_encode(['error' => 'Los campos título, subtítulo y descripción son obligatorios.']);
                break;
            }

            $image = $_FILES['image'] ?? null;
            $audio = $_FILES['audio'] ?? null;
            $video = $_FILES['video'] ?? null;

            if (saveInfo($data['title'], $data['subtitle'], $data['description'], $image, $audio, $video)) {
                echo json_encode(['message' => 'Información guardada exitosamente.']);
            } else {
                echo json_encode(['error' => 'No se pudo guardar la información.']);
            }
        }
        break;

    case 'updateInfo':
        if ($method === 'POST') { // Cambiado a POST para facilitar el manejo de archivos
            $data = $_POST;

            if (empty($data['id']) || empty($data['title']) || empty($data['subtitle']) || empty($data['description'])) {
                echo json_encode(['error' => 'Faltan campos obligatorios.']);
                break;
            }

            $image = $_FILES['image'] ?? null;
            $audio = $_FILES['audio'] ?? null;
            $video = $_FILES['video'] ?? null;

            if (updateInfo($data['id'], $data['title'], $data['subtitle'], $data['description'], $image, $audio, $video)) {
                echo json_encode(['message' => 'Información actualizada exitosamente.']);
            } else {
                echo json_encode(['error' => 'No se pudo actualizar la información.']);
            }
        }
        break;
        case 'getInfoById':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
        
                if (empty($data['id'])) {
                    echo json_encode(['error' => 'El campo id es obligatorio.']);
                    break;
                }
        
                $info = getInfoById($data['id']);
        
                if ($info) {
                    // Añade tipos MIME según el archivo
                    $info['image_mime'] = $info['image'] ? 'image/jpeg' : null; // Puedes ajustar según la extensión detectada
                    $info['audio_mime'] = $info['audio'] ? 'audio/mpeg' : null;
                    $info['video_mime'] = $info['video'] ? 'video/mp4' : null;
        
                    echo json_encode($info);
                } else {
                    echo json_encode(['error' => 'No se encontró información para el ID proporcionado.']);
                }
            }
            break;
        

    default:
        echo json_encode(['error' => 'Endpoint no válido.']);
}
?>
