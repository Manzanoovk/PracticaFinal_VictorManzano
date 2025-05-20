<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // Por defecto en XAMPP
$base_datos = "tienda_virtual";

try {
    $conn = new PDO("mysql:host=$host;dbname=$base_datos;charset=utf8", $usuario, $contrasena);
    // Activamos el modo de errores con excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}
?>