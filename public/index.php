<?php

require_once __DIR__ . '/../controllers/productoController.php';
require_once __DIR__ . '/../controllers/ventaController.php';

$pCtrl = new ProductoController();
$vCtrl = new VentaController();

$totalProductos = count($pCtrl->index());
$ventasData = $vCtrl->index();
$gananciaTotal = 0;
foreach($ventasData['ventas'] as $v) {
    $gananciaTotal += $v['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA BASSKA </title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="app-container">
    <div class="welcome-text">
        <h1>SISTEMA <span>BASSKA</span></h1>
        <p>Panel de administración de inventario y ventas</p>
    </div>

    <div class="dashboard-grid">
        <a href="productos.php" class="card-dashboard">
            <p>Estado del inventario</p>
            <h2>Productos</h2>
            <span class="stat-number"><?= $totalProductos ?></span>
            <div class="btn-pro btn-azul">Gestionar Stock</div>
        </a>

        <a href="ventas.php" class="card-dashboard">
            <p>Rendimiento económico</p>
            <h2>Ventas</h2>
            <span class="stat-number">$<?= number_format($gananciaTotal, 2) ?></span>
            <div class="btn-pro btn-rosa">Nueva Transacción</div>
        </a>
    </div>

    <div style="text-align: center; margin-top: 50px; color: rgba(255,255,255,0.5); font-size: 0.8rem;">
          BASSKA/AVILA SEBASTIAN ECOTEC - Todos los derechos reservados.
    </div>
</div>

</body>
</html>