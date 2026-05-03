<?php
require_once __DIR__ . '/../controllers/productoController.php';

$controller = new productoController(); 
$controller->procesar();
$productos = $controller->index();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | BASSKA System</title>
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
                    <label class="label-custom">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control-custom" placeholder="Ej. Laptop Gaming" required>
                </div>
                
                <div class="form-group">
                    <label class="label-custom">Precio Unitario ($)</label>
                    <input type="number" step="0.01" name="precio" class="form-control-custom" placeholder="0.00" required>
                </div>
                
                <div class="form-group">
                    <label class="label-custom">Stock Disponible</label>
                    <input type="number" name="stock" class="form-control-custom" placeholder="Cantidad inicial" required>
                </div>
                
                <button type="submit" class="btn-pro btn-azul btn-full">GUARDAR PRODUCTO</button>
            </form>
        </div>

        <div class="contenedor-principal">
            <h3 class="section-subtitle">Inventario en Tiempo Real</h3>
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
                                    <button class="btn-pro btn-azul" style="padding: 5px 10px; font-size: 0.7rem;" 
                                            onclick="abrirModal(<?= $p['id'] ?>, '<?= addslashes($p['nombre']) ?>', <?= $p['precio'] ?>, <?= $p['stock'] ?>)">
                                        Editar
                                    </button>
                                    <a href="?eliminar=<?= $p['id'] ?>" class="btn-pro btn-rosa" 
                                       style="padding: 5px 10px; font-size: 0.7rem;"
                                       onclick="return confirm('¿Estás seguro de eliminar este producto?')">Borrar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="status-empty">No hay datos para mostrar. Verifica la conexión a MySQL en XAMPP.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="modalEditar" class="modal">
    <div class="modal-content">
        <h3 class="section-subtitle">Actualizar Producto</h3>
        <form action="" method="POST">
            <input type="hidden" name="accion" value="editar">
            <input type="hidden" name="id_edit" id="edit_id">
            
            <div class="form-group">
                <label class="label-custom">Nombre</label>
                <input type="text" name="nombre" id="edit_nombre" class="form-control-custom" required>
            </div>
            
            <div class="form-group">
                <label class="label-custom">Precio ($)</label>
                <input type="number" step="0.01" name="precio" id="edit_precio" class="form-control-custom" required>
            </div>
            
            <div class="form-group">
                <label class="label-custom">Stock</label>
                <input type="number" name="stock" id="edit_stock" class="form-control-custom" required>
            </div>
            
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn-pro btn-azul btn-full">CONFIRMAR CAMBIOS</button>
                <button type="button" class="btn-pro btn-regreso" onclick="cerrarModal()">CANCELAR</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModal(id, nombre, precio, stock) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_precio').value = precio;
    document.getElementById('edit_stock').value = stock;
    document.getElementById('modalEditar').style.display = 'block';
}

function cerrarModal() {
    document.getElementById('modalEditar').style.display = 'none';
}

window.onclick = function(event) {
    var modal = document.getElementById('modalEditar');
    if (event.target == modal) { cerrarModal(); }
}
</script>

</body>
</html>