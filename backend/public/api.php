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

                // Verificación del reCAPTCHA
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

                // Verificación del reCAPTCHA
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

                if (registerUser($data['username'], $data['password'])) {
                    echo json_encode(['message' => 'Usuario registrado exitosamente.']);
                } else {
                    throw new Exception('No se pudo registrar el usuario. Es posible que el nombre de usuario ya exista.');
                }
            }
            break;

        // Otros endpoints...
        default:
            throw new Exception('Endpoint no válido.');
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
