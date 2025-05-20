<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

include "conexion.php";

// Obtener productos
$stmt = $conn->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Virtual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos personalizados para las imágenes de las tarjetas -->
    <style>
        .card-img-top {
            object-fit: cover;
            height: 200px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Bienvenido, <?= htmlspecialchars($_SESSION["usuario"]) ?> 👋</h2>
    <a href="logout.php" class="btn btn-danger mb-4">Cerrar sesión</a>
    <a href="exportar_catalogo.php" class="btn btn-outline-secondary mb-4 ms-2">📄 Descargar catálogo XML</a>
    <a href="historial.php" class="btn btn-outline-primary mb-4 ms-2">🧾 Ver historial de compras</a>

    <h3>Catálogo de productos</h3>
    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm h-100">
                    <?php if (!empty($producto["imagen"])): ?>
                        <img src="img/<?= htmlspecialchars($producto["imagen"]) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto["nombre"]) ?>">
                    <?php else: ?>
                        <img src="img/" class="card-img-top" alt="Sin imagen">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto["nombre"]) ?></h5>
                        <p class="card-text">Precio: <?= number_format($producto["precio"], 2) ?> €</p>
                        <form action="comprar.php" method="POST">
                            <input type="hidden" name="referencia" value="<?= $producto["referencia"] ?>">
                            <button type="submit" class="btn btn-success w-100">Comprar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>