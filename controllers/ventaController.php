<?php
require_once __DIR__ . '/../services/ventaservicio.php';
require_once __DIR__ . '/../models/producto.php';

class VentaController {
    private $servicio;
    private $modeloProducto;

    public function __construct() {
        $this->servicio = new VentaServicio();
        $this->modeloProducto = new Producto();
    }

    public function index() {
        // Obtenemos productos para el select y las ventas para la tabla
        return [
            'productos' => $this->modeloProducto->listar(),
            'ventas' => (new Venta())->listarVentas()
        ];
    }

    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['producto_id'];
            $cant = (int)$_POST['cantidad'];

            $error = $this->servicio->ejecutarVenta($id, $cant);

            if ($error === true) {
                header("Location: ventas.php?success=1");
            } else {
                header("Location: ventas.php?error=" . urlencode($error));
            }
            exit();
        }
    }
}