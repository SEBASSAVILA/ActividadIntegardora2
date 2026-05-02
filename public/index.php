<?php
require_once __DIR__ . '/../models/producto.php';
require_once __DIR__ . '/../models/venta.php';

$pModel = new Producto();
$vModel = new Venta();

$totalProductos = count($pModel->listar());
$ventas = $vModel->listarVentas();
$gananciaTotal = array_sum(array_column($ventas, 'total'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control | Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">📦 MiSistema Stock</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="index.php">Inicio</a>
                <a class="nav-link" href="productos.php">Productos</a>
                <a class="nav-link" href="ventas.php">Ventas</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Bienvenido al Panel de Control</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Productos en Inventario</h5>
                        <p class="display-4"><?= $totalProductos ?></p>
                        <a href="productos.php" class="btn btn-outline-light">Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3 shadow">
                    <div class="card-body">
                        <h5 class="card-title">Ganancia Total</h5>
                        <p class="display-4">$<?= number_format($gananciaTotal, 2) ?></p>
                        <a href="ventas.php" class="btn btn-outline-light">Ver Historial</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>