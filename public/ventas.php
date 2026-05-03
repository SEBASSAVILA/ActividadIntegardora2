<?php
require_once __DIR__ . '/../controllers/ventaController.php';

$controller = new VentaController();
$controller->procesar();

$datos = $controller->index();
$productos = $datos['productos'];
$ventas = $datos['ventas'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas </title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="app-container">
    <div class="header-flex">
        <h1 class="title-main">Módulo de <strong class="title-bold">VENTAS</strong></h1>
        <a href="index.php" class="btn-pro btn-regreso">VOLVER AL INICIO</a>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert-custom alert-success">¡Venta completada con éxito!</div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert-custom alert-error">Error: <?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <div class="grid-layout">
        <div class="contenedor-principal">
            <h3 class="section-subtitle">Registrar Nueva Venta</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <label class="label-custom">Seleccionar Producto</label>
                    <select name="producto_id" class="form-control-custom" required>
                        <option value="">Elija un producto...</option>
                        <?php foreach($productos as $prod): ?>
                            <option value="<?= $prod['id'] ?>">
                                <?= htmlspecialchars($prod['nombre']) ?> (Stock: <?= $prod['stock'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="label-custom">Cantidad a vender</label>
                    <input type="number" name="cantidad" class="form-control-custom" min="1" required>
                </div>
                
                <button type="submit" class="btn-pro btn-azul btn-full">COMPLETAR VENTA</button>
            </form>
        </div>

        <div class="contenedor-principal">
            <h3 class="section-subtitle">Historial de Transacciones</h3>
            <div class="table-container">
                <table class="tabla-limpia">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ventas)): ?>
                            <?php foreach ($ventas as $v): ?>
                            <tr>
                                <td style="font-size: 0.85rem; color: #636e72;"><?= $v['fecha_venta'] ?></td>
                                <td style="font-weight: 600;"><?= htmlspecialchars($v['nombre']) ?></td>
                                <td><?= $v['cantidad'] ?></td>
                                <td class="text-price">$<?= number_format($v['total'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="status-empty">No se han realizado ventas.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>