<?php
// Inicia la sesión para poder acceder a los datos guardados
session_start();

// Elimina todos los datos de la sesión actual (cierra la sesión del usuario)
session_destroy();

// Redirige al usuario a la página de login tras cerrar sesión
header("Location: login.html");

// Finaliza el script para evitar que se siga ejecutando código después de la redirección
exit();
?>