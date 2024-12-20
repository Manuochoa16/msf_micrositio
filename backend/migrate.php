<?php
echo "Script de migración ejecutándose...\n";
require_once __DIR__ . '/src/db.php';

try {
    // Crear la tabla sections
    $pdo->exec("CREATE TABLE IF NOT EXISTS sections (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");
    echo "Tabla 'sections' creada exitosamente.\n";

    // Crear la tabla anchors
    $pdo->exec("CREATE TABLE IF NOT EXISTS anchors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        section_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (section_id) REFERENCES sections(id) ON DELETE CASCADE
    )");
    echo "Tabla 'anchors' creada exitosamente.\n";

    // Crear la tabla contents
    $pdo->exec("CREATE TABLE IF NOT EXISTS contents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        anchor_id INT NOT NULL,
        type ENUM('title', 'subtitle', 'description', 'image', 'audio', 'video') NOT NULL,
        content TEXT,
        file_path VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (anchor_id) REFERENCES anchors(id) ON DELETE CASCADE
    )");
    echo "Tabla 'contents' creada exitosamente.\n";

    // Crear la tabla media_files
    $pdo->exec("CREATE TABLE IF NOT EXISTS media_files (
        id INT AUTO_INCREMENT PRIMARY KEY,
        anchor_id INT NOT NULL,
        file_type ENUM('image', 'audio', 'video') NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        file_size INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (anchor_id) REFERENCES anchors(id) ON DELETE CASCADE
    )");
    echo "Tabla 'media_files' creada exitosamente.\n";
    
} catch (PDOException $e) {
    echo "Error al crear las tablas: " . $e->getMessage();
}
?>
