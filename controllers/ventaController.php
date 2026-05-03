<?php
require_once __DIR__ . '/../services/ventaservicio.php';
require_once __DIR__ . '/../models/producto.php';
require_once __DIR__ . '/../models/venta.php'; 

class VentaController {
    private $servicio;
    private $modeloProducto;
    private $modeloVenta;

    public function __construct() {
        $this->servicio = new VentaServicio();
        $this->modeloProducto = new Producto();
        $this->modeloVenta = new Venta(); // instacia la orden 
    }

    public function index() {
        // Obtenemos productos para el select y las ventas para la tabla
        return [
            'productos' => $this->modeloProducto->listar(),
            'ventas' => $this->modeloVenta->listarVentas()
        ];
    }

    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // verifica datos existentes
            $id = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;
            $cant = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 0;

            //llama el servicio
            $resultado = $this->servicio->ejecutarVenta($id, $cant);

            if ($resultado === true) {
                header("Location: ventas.php?success=1");
            } else {
                // $resultado contiene el mensaje de texto del error
                header("Location: ventas.php?error=" . urlencode($resultado));
            }
            exit();
        }
    }
}