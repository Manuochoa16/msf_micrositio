<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


// Extraer los componentes de la URL
$host = $_ENV['MYSQL_HOST']; // autorack.proxy.rlwy.net
$dbname = $_ENV['MYSQL_DATABASE']; // railway
$username = $_ENV['MYSQL_USER']; // root
$password = $_ENV['MYSQL_ROOT_PASSWORD']; // fyAHXQKUbPNyXZLwPWjdsbNKfvTEosqU
$port = $_ENV['MYSQL_PORT']; // 55045

try {
    // Crear la conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    die(json_encode(['error' => 'Database connection failed', 'message' => $e->getMessage()]));
}
?>
