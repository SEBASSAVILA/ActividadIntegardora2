<?php
// Importamos el controlador
require_once __DIR__ . '/../controllers/productoController.php';

$controller = new ProductoController();

// Si viene una peticion POST, registramos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller->registrar();
}

// Si viene una peticion para eliminar por GET
if (isset($_GET['action']) && $_GET['action'] == 'eliminar') {
    $controller->eliminar();
}

// Obtenemos la lista de productos para la tabla
$productos = $controller->mostrarProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Agregar Producto</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger small"><?= htmlspecialchars($_GET['error']) ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success small">¡Producto guardado!</div>
                    <?php endif; ?>

                    <form action="productos.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio</label>
                            <input type="number" name="precio" step="0.01" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Guardar Producto</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Inventario Actual</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
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
                            <?php foreach ($productos as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= htmlspecialchars($p['nombre']) ?></td>
                                <td>$<?= number_format($p['precio'], 2) ?></td>
                                <td>
                                    <span class="badge <?= $p['stock'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $p['stock'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="productos.php?action=eliminar&id=<?= $p['id'] ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('¿Seguro que quieres eliminarlo?')">Borrar</a>
                                </td>
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