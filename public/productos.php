<?php
require_once __DIR__ . '/../controllers/productoController.php';

$controller = new ProductoController();
$controller->procesar(); 
$productos = $controller->index(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | Sistema Pro</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="app-container">
    <div class="header-flex">
        <h1 class="title-main">Gestión de <strong class="title-bold">PRODUCTOS</strong></h1>
        <a href="index.php" class="btn-pro btn-regreso">VOLVER AL INICIO</a>
    </div>

    <div class="grid-layout">
        <div class="contenedor-principal">
            <h3 class="section-subtitle">Nuevo Registro</h3>
            <form action="" method="POST">
                <div class="form-group">
                    <label class="label-custom">Nombre</label>
                    <input type="text" name="nombre" class="form-control-custom" placeholder="Ej. Laptop" required>
                </div>
                
                <div class="form-group">
                    <label class="label-custom">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control-custom" placeholder="0.00" required>
                </div>
                
                <div class="form-group">
                    <label class="label-custom">Stock</label>
                    <input type="number" name="stock" class="form-control-custom" placeholder="Cantidad" required>
                </div>
                
                <button type="submit" class="btn-pro btn-azul btn-full">GUARDAR PRODUCTO</button>
            </form>
        </div>

        <div class="contenedor-principal">
            <h3 class="section-subtitle">Inventario Actual</h3>
            <div class="table-container">
                <table class="tabla-limpia">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos)): ?>
                            <?php foreach ($productos as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td style="font-weight: 600;"><?= htmlspecialchars($p['nombre']) ?></td>
                                <td class="text-price">$<?= number_format($p['precio'], 2) ?></td>
                                <td>
                                    <span class="<?= ($p['stock'] <= 0) ? 'badge-danger' : '' ?>">
                                        <?= $p['stock'] ?> uds
                                    </span>
                                </td>
                                <td>
                                    <a href="?eliminar=<?= $p['id'] ?>" class="btn-pro btn-rosa" onclick="return confirm('¿Eliminar producto?')">Borrar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="status-empty">No hay productos registrados aún.</td>
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