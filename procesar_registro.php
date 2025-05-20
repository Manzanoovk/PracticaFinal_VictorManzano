<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexion.php";

    // Recoger datos
    $usuario = $_POST["usuario"];
    $contraseña = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $correo = $_POST["correo"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $genero = $_POST["genero"];

    try {
        // Insertar usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, contraseña) VALUES (?, ?)");
        $stmt->execute([$usuario, $contraseña]);

        // Insertar cliente
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, apellidos, correo, fecha_nacimiento, genero) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellidos, $correo, $fecha_nacimiento, $genero]);

        echo "Registro exitoso. <a href='login.html'>Iniciar sesión</a>";

    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
    }

    $conn = null;
}
?>