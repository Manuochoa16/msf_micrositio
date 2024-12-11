<?php
require_once 'db.php';

function saveFile($name, $type, $content) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO files (file_name, file_type, file_content) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $type, $content]);
}

function getFiles() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM files ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateFile($id, $name, $type, $content) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE files SET file_name = ?, file_type = ?, file_content = ? WHERE id = ?");
    return $stmt->execute([$name, $type, $content, $id]);
}
?>
