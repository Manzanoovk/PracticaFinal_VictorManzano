<?php

// Verifica que el usuario haya iniciado sesión; si no, lo redirige al login.
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html");
    exit();
}

include "conexion.php";

$usuario = $_SESSION["usuario"];

$stmt = $conn->prepare("
    SELECT c.fecha_compra, p.nombre, p.precio, p.referencia, p.imagen
    FROM compras c
    JOIN productos p ON c.referencia_producto = p.referencia
    WHERE c.usuario = ?
    ORDER BY c.fecha_compra DESC
");

// Consulta que obtiene todas las compras del usuario junto con los datos del producto.
$stmt->execute([$usuario]);
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras</title>

    <!-- Bootstrap CSS para diseño responsive y componentes estilizados -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Estilos para las imágenes de los productos en la tabla */
        .producto-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <!-- Título principal con nombre del usuario -->
    <h2 class="mb-4">🧾 Historial de compras de <?= htmlspecialchars($usuario) ?></h2>
    
    <!-- Botón para volver a la tienda -->
    <a href="tienda.php" class="btn btn-secondary mb-3">← Volver a la tienda</a>

    <?php if (count($compras) > 0): ?>
        <!-- Tabla de compras -->
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Fecha de compra</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($compras as $compra): ?>
                    <tr>
                        <td>
                            <img src="img/<?= !empty($compra["imagen"]) ? htmlspecialchars($compra["imagen"]) : 'default.jpg' ?>"
                                 class="producto-img" alt="<?= htmlspecialchars($compra["nombre"]) ?>">
                        </td>
                        <td><?= htmlspecialchars($compra["nombre"]) ?></td>
                        <td><?= number_format($compra["precio"], 2) ?> €</td>
                        <td><?= $compra["fecha_compra"] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <!-- Mensaje si no hay compras registradas -->
        <div class="alert alert-info">Aún no has realizado ninguna compra.</div>
    <?php endif; ?>
</div>

</body>
</html>