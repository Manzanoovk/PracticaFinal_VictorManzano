<?php
// Verifica que el usuario esté logueado. Si no, lo redirige al login.
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["referencia"])) {
    include "conexion.php";

    $usuario = $_SESSION["usuario"];
    $referencia = $_POST["referencia"];

    try {
        // Registra la compra en la tabla 'compras'
        $stmt = $conn->prepare("INSERT INTO compras (usuario, referencia_producto) VALUES (?, ?)");
        $stmt->execute([$usuario, $referencia]);

        // Aqui se obtiene información del producto comprado
        $stmt = $conn->prepare("SELECT nombre, precio, imagen FROM productos WHERE referencia = ?");
        $stmt->execute([$referencia]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
?>
  
<!DOCTYPE html>
<!--Aqui esta el codigo en html para que cuando se realize una compra salga el mensaje correspondiente.-->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra realizada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .producto-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">

    <?php if (isset($producto)): ?>
        <div class="alert alert-success text-center">
            <h4 class="alert-heading">✅ ¡Compra realizada con éxito!</h4>
            <p>Has comprado: <strong><?= htmlspecialchars($producto["nombre"]) ?></strong></p>
            <img src="img/<?= htmlspecialchars($producto["imagen"]) ?>" class="producto-img my-3" alt="Producto">
            <p class="mb-0">Precio: <strong><?= number_format($producto["precio"], 2) ?> €</strong></p>
        </div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger">
            <h4 class="alert-heading">❌ Error en la compra</h4>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <h4 class="alert-heading">⚠️ No se recibió ningún producto</h4>
            <p>Intenta realizar la compra desde la tienda.</p>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="tienda.php" class="btn btn-primary">← Volver a la tienda</a>
        <a href="historial.php" class="btn btn-outline-primary">🧾 Ver historial</a>
    </div>

</div>
</body>
</html>