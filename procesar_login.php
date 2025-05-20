<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conecta con la base de datos
    include "conexion.php";


    // Recoge los datos enviados desde el formulario
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];


    // Consulta la contraseña hasheada del usuario en la base de datos
    $stmt = $conn->prepare("SELECT contraseña FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);


    // Verifica si el usuario existe y si la contraseña ingresada coincide con el hash
    if ($resultado && password_verify($contraseña, $resultado["contraseña"])) {
        $_SESSION["usuario"] = $usuario;
        header("Location: tienda.php"); // Redirige al usuario a la tienda si el login es correcto
        exit();
    } else {
        // Mensaje si las credenciales son incorrectas
        echo "Usuario o contraseña incorrectos. <a href='login.html'>Volver</a>";
    }

    $conn = null; // Aqui se termina la conexion
}
?>