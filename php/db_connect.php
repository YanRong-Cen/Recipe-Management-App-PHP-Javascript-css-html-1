<?php
$host = 'localhost';
$dbname = 'recipe';
$username = 'root';
$password = '';
$port = '3308'; // Missing semicolon added here

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Database connection failed: ' . htmlspecialchars($e->getMessage());
    exit();
}
?>