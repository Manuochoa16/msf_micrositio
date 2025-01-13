<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';


$dotenvPath = realpath(__DIR__ . '/../../../'); 
if (!file_exists($dotenvPath . '/.env')) {
    die("El archivo .env no se encuentra en " . $dotenvPath . '/.env');
}

// Cargar las variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
$dotenv->load();

// Obtener las variables de entorno
$host = $_ENV['MYSQL_HOST'];
$dbname = $_ENV['MYSQL_DATABASE'];
$username = $_ENV['MYSQL_USER'];
$password = $_ENV['MYSQL_PASSWORD'];
$port = $_ENV['MYSQL_PORT'];

try {
    // Intentar conectar con la base de datos
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Database connection failed', 'message' => $e->getMessage()]));
}
