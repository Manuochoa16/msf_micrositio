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

    case 'files':
        if ($method === 'GET') {
            echo json_encode(getFiles());
        } elseif ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (saveFile($data['file_name'], $data['file_type'], $data['file_content'])) {
                echo json_encode(['message' => 'Archivo guardado exitosamente.']);
            } else {
                echo json_encode(['error' => 'No se pudo guardar el archivo.']);
            }
        } elseif ($method === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (updateFile($data['id'], $data['file_name'], $data['file_type'], $data['file_content'])) {
                echo json_encode(['message' => 'Archivo actualizado exitosamente.']);
            } else {
                echo json_encode(['error' => 'No se pudo actualizar el archivo.']);
            }
        }
        break;

    default:
        echo json_encode(['error' => 'Endpoint no válido.']);
}
?>
