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

    /**
     * Lógica de negocio para ejecutar una venta
     * Retorna true si fue exitosa o un string con el mensaje de error
     */
    public function ejecutarVenta(int $productoId, int $cantidad) {
        if ($cantidad <= 0) {
            return "La cantidad debe ser mayor a cero.";
        }

        // busca el producto para verificar existencia y stock actual
        // ya que reutiliza el listar() para no crear métodos extra, o puedes crear un buscarPorId
        $productos = $this->modeloProducto->listar();
        $productoEncontrado = null;

        foreach ($productos as $p) {
            if ($p['id'] == $productoId) {
                $productoEncontrado = $p;
                break;
            }
        }

        // verifica la regal de nbegocio 
        if (!$productoEncontrado) {
            return "El producto seleccionado no existe en el sistema.";
        }

        if ($productoEncontrado['stock'] < $cantidad) {
            return "Stock insuficiente. Solo quedan " . $productoEncontrado['stock'] . " unidades de " . $productoEncontrado['nombre'];
        }
        // pasa el precio actual para que el total de la venta sea correcto
        $resultado = $this->modeloVenta->registrarVenta(
            $productoId, 
            $cantidad, 
            (float)$productoEncontrado['precio']
        );

        if ($resultado) {
            return true;
        } else {
            return "Error crítico: No se pudo completar la transacción en la base de datos.";
        }
    }
}