<?php
$host = getenv('MYSQL_HOST') ?: 'db';
$dbname = getenv('MYSQL_DATABASE') ?: 'photest';
$username = getenv('MYSQL_USER') ?: 'photest_user';
$password = getenv('MYSQL_PASSWORD') ?: 'photest_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
