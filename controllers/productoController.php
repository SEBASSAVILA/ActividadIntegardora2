<?php
require_once __DIR__ . '/../models/producto.php';

class ProductoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Producto();
    }

    public function mostrarProductos() {
        return $this->modelo->listar();
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Capturamos y limpiamos ligeramente los datos
            $nombre = $_POST['nombre'] ?? '';
            $precio = (float)($_POST['precio'] ?? 0);
            $stock  = (int)($_POST['stock'] ?? 0);

            // Llamamos al modelo (que ahora devuelve un array)
            $resultado = $this->modelo->crear($nombre, $precio, $stock);

            if ($resultado['ok']) {
                // Si todo salió bien, redirigimos con exito
                header("Location: productos.php?success=1");
            } else {
                $errorMsg = implode(", ", $resultado['errores']);
                header("Location: productos.php?error=" . urlencode($errorMsg));
            }
            exit();
        }
    }

    // No olvides agregar la acción para eliminar que también pide tu tarea
    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            if ($this->modelo->eliminar($id)) {
                header("Location: productos.php?mensaje=eliminado");
            } else {
                header("Location: productos.php?error=no_se_pudo_eliminar");
            }
            exit();
        }
    }
}