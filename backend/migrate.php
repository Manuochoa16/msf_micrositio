<?php
echo "Script de migración ejecutándose...\n";
require_once __DIR__ . '/src/db.php';


try {
    // Crear la tabla `users`
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Tabla 'users' creada exitosamente.\n";

    // Crear la tabla `info`
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS info (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            subtitle VARCHAR(255),
            description TEXT,
            image LONGBLOB,
            audio LONGBLOB,
            video LONGBLOB,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "Tabla 'info' creada exitosamente.\n";

} catch (PDOException $e) {
    echo "Error al crear las tablas: " . $e->getMessage();
}
