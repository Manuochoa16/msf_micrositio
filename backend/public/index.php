<?php
require_once __DIR__ . '/../src/db.php'; 


$nombre = 'Esteban Scalerandi';
$correo = 'teten08@hotmail.com';

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo) VALUES (?, ?)");
    $stmt->execute([$nombre, $correo]);
    echo "Usuario registrado exitosamente.";
} catch (PDOException $e) {
    die("Error al insertar: " . $e->getMessage());
}
