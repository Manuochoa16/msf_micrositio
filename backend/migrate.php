<?php
// Configuración de la base de datos
$host = 'autorack.proxy.rlwy.net'; // Host público proporcionado por Railway
$port = '55045'; // Puerto público proporcionado por Railway
$dbname = 'railway';
$username = 'root';
$password = 'fyAHXQKUbPNyXZLwPWjdsbNKfvTEosqU';
$charset = 'utf8mb4';

try {
    // Establecer la conexión PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    echo "Conexión exitosa a la base de datos.\n";

    // Crear tabla sections
    $pdo->exec("CREATE TABLE IF NOT EXISTS sections (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) UNIQUE NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Crear tabla titles
    $pdo->exec("CREATE TABLE IF NOT EXISTS titles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        section_id INT NOT NULL,
        title_text VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
    )");

    // Crear tabla subtitles
    $pdo->exec("CREATE TABLE IF NOT EXISTS subtitles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title_id INT NOT NULL,
        subtitle_text VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (title_id) REFERENCES titles(id) ON DELETE CASCADE
    )");

    // Crear tabla paragraphs
    $pdo->exec("CREATE TABLE IF NOT EXISTS paragraphs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title_id INT NOT NULL,
        paragraph_text TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (title_id) REFERENCES titles(id) ON DELETE CASCADE
    )");

    // Crear tabla media_files
    $pdo->exec("CREATE TABLE IF NOT EXISTS media_files (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title_id INT NOT NULL,
        file_type ENUM('image', 'video', 'audio') NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        file_size INT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (title_id) REFERENCES titles(id) ON DELETE CASCADE
    )");

    echo "Tablas creadas exitosamente.\n";

} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
