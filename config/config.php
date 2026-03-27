<?php

// Base_url es temporal hasta que tenga el dominio, cuando lo tenga, lo cambio ahi

define('BASE_URL', 'http://localhost/TFG');

// base de datos

$host = "localhost";
$db_name = "casamujeresvallekas"; 
$username = "root";
$password = ""; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// phpmailer

define ('SMTP_HOST', 'smtp.gmail.com');
define ('SMTP_USER', 'ananevadodeoyarbide@gmail.com');
define ('SMTP_PASS', 'iycnzgjhuxphusjb');
define ('SMTP_PORT', 587);
define ('SMTP_FROM', 'ananevadodeoyarbide@gmail.com');
define ('SMTP_NAME', 'Web Casa de las mujeres Vallekas');

?> 