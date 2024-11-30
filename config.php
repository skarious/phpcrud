<?php
// Configuración para entorno de producción o desarrollo
$is_production = true; // Cambiar a false para desarrollo local

if ($is_production) {
    // Configuración para EasyPanel
    $host = getenv('MYSQL_HOST') ?: 'db';
    $dbname = getenv('MYSQL_DATABASE') ?: 'todo_db';
    $username = getenv('MYSQL_USER') ?: 'todo_user';
    $password = getenv('MYSQL_PASSWORD') ?: 'todo_password';
} else {
    // Configuración para desarrollo local
    $host = getenv('MYSQL_HOST') ?: 'db';
    $dbname = getenv('MYSQL_DATABASE') ?: 'todo_db';
    $username = getenv('MYSQL_USER') ?: 'todo_user';
    $password = getenv('MYSQL_PASSWORD') ?: 'todo_password';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
