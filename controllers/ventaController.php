<?php
require_once __DIR__ . '/../models/venta.php';
require_once __DIR__ . '/../models/producto.php';

class VentaController {
    private $modeloVenta;
    private $modeloProducto;

    public function __construct() {
        $this->modeloVenta = new Venta();
        $this->modeloProducto = new Producto();
    }

    public function index() {
        // Necesitamos los productos para llenar el select del formulario
        $productos = $this->modeloProducto->listar();
        $ventas = $this->modeloVenta->listarVentas();
        return ['productos' => $productos, 'ventas' => $ventas];
    }

    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productoId = (int)$_POST['producto_id'];
            $cantidad = (int)$_POST['cantidad'];

            $res = $this->modeloVenta->registrarVenta($productoId, $cantidad);
            
            if ($res['ok']) {
                header("Location: ventas.php?success=1");
            } else {
                header("Location: ventas.php?error=" . urlencode($res['error']));
            }
            exit();
        }
    }
}