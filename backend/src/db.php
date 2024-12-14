<?php
// Ya no es necesario cargar phpdotenv, ya que las variables de entorno están definidas en Render

// Extraer los componentes de la URL directamente desde las variables de entorno
$host = getenv('MYSQL_HOST'); // autorack.proxy.rlwy.net
$dbname = getenv('MYSQL_DATABASE'); // railway
$username = getenv('MYSQL_USER'); // root
$password = getenv('MYSQL_ROOT_PASSWORD'); // fyAHXQKUbPNyXZLwPWjdsbNKfvTEosqU
$port = getenv('MYSQL_PORT'); // 55045

try {
    // Crear la conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
} catch (PDOException $e) {
    die(json_encode(['error' => 'Database connection failed', 'message' => $e->getMessage()]));
}
?>
