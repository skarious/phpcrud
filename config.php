<?php
// Configuración para entorno de producción o desarrollo
$is_production = true; // Cambiar a false para desarrollo local

if ($is_production) {
    // Configuración para EasyPanel
    $host = 'localhost';
    $dbname = 'photest'; // Reemplaza con el nombre de tu base de datos en EasyPanel
    $username = 'photest_user'; // Reemplaza con tu usuario de base de datos
    $password = 'photest_password'; // Reemplaza con tu contraseña
} else {
    // Configuración para desarrollo local
    $host = getenv('MYSQL_HOST') ?: 'db';
    $dbname = getenv('MYSQL_DATABASE') ?: 'photest';
    $username = getenv('MYSQL_USER') ?: 'photest_user';
    $password = getenv('MYSQL_PASSWORD') ?: 'photest_password';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
