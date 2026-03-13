<?php
$host = 'localhost';
$dbname = 'casamujeresvallekas';
$username = 'root';
$password= '';

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo=new PDO ($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error de conexión a la base de datos. Por favor, inténtalo más tarde.");
}