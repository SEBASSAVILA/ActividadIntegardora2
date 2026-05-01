<?php
require_once __DIR__ . '/../models/venta.php';
require_once __DIR__ . '/../models/producto.php';

class VentaServicio {
    private $modeloVenta;
    private $modeloProducto;

    public function __construct() {
        $this->modeloVenta = new Venta();
        $this->modeloProducto = new Producto();
    }

    public function ejecutarVenta(int $productoId, int $cantidad) {
        // 1. Buscamos el producto para ver si existe y tiene stock
        // Aquí podrías crear un método "obtenerPorId" en tu modelo producto
        $productos = $this->modeloProducto->listar();
        $productoSeleccionado = null;

        foreach ($productos as $p) {
            if ($p['id'] == $productoId) {
                $productoSeleccionado = $p;
                break;
            }
        }

        if (!$productoSeleccionado) return "Error: Producto no encontrado.";
        if ($productoSeleccionado['stock'] < $cantidad) {
            return "Error: No hay suficiente stock (Disponible: " . $productoSeleccionado['stock'] . ")";
        }

        // 2. Si hay stock, mandamos a registrar la venta
        return $this->modeloVenta->registrarVenta($productoId, $cantidad, $productoSeleccionado['precio']);
    }
}