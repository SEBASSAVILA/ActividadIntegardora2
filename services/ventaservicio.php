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
        // 1. Validaciones básicas de entrada
        if ($cantidad <= 0) {
            return "La cantidad debe ser mayor a cero.";
        }

        // 2. Buscar el producto para verificar existencia y stock actual
        // Reutilizamos el listar() para no crear métodos extra, o puedes crear un buscarPorId
        $productos = $this->modeloProducto->listar();
        $productoEncontrado = null;

        foreach ($productos as $p) {
            if ($p['id'] == $productoId) {
                $productoEncontrado = $p;
                break;
            }
        }

        // 3. Verificaciones de reglas de negocio
        if (!$productoEncontrado) {
            return "El producto seleccionado no existe en el sistema.";
        }

        if ($productoEncontrado['stock'] < $cantidad) {
            return "Stock insuficiente. Solo quedan " . $productoEncontrado['stock'] . " unidades de " . $productoEncontrado['nombre'];
        }

        // 4. Si todo está OK, procedemos a la base de datos
        // Pasamos el precio actual para que el total de la venta sea correcto
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