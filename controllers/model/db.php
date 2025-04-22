<?php
// Datos de conexión a la base de datos
$host = "localhost";
$user = "root";         // Usuario de phpMyAdmin
$password = "";         // Contraseña (deja vacío si no tiene)
$dbname = "techover";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
