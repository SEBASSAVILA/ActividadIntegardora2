<?php
require_once __DIR__ . '/../controllers/ventaController.php';

$ventaController = new VentaController();

// Procesar el registro si viene por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ventaController->procesar();
}

// Obtener datos para la vista (lista de productos y lista de ventas)
$datos = $ventaController->index();
$productos = $datos['productos'];
$ventas = $datos['ventas'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="productos.php">Inventario</a>
        <a class="navbar-brand" href="ventas.php">Ventas</a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-success shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Registrar Nueva Venta</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">Venta realizada correctamente.</div>
                    <?php endif; ?>

                    <form action="ventas.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Seleccionar Producto</label>
                            <select name="producto_id" class="form-select" required>
                                <option value="">Elija un producto...</option>
                                <?php foreach ($productos as $p): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= htmlspecialchars($p['nombre']) ?> (Stock: <?= $p['stock'] ?>)
                                    </option>
                                <<?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cantidad a vender</label>
                            <input type="number" name="cantidad" class="form-control" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Completar Venta</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Historial de Transacciones</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $v): ?>
                            <tr>
                                <td><?= $v['fecha_venta'] ?></td>
                                <td><?= htmlspecialchars($v['nombre']) ?></td>
                                <td><?= $v['cantidad'] ?></td>
                                <td>$<?= number_format($v['total'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>