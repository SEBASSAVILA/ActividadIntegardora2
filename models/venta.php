<?php
require_once __DIR__ . '/../config/database.php';

class Venta {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function registrarVenta(int $productoId, int $cantidad): array {
        try {
            $this->db->beginTransaction(); // inicia la transaccion

            // obetenemos los datos del producto para el precio y verifica el stock
            $stmt = $this->db->prepare("SELECT precio, stock, nombre FROM productos WHERE id = :id");
            $stmt->execute([':id' => $productoId]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$producto) throw new Exception("El producto no existe.");
            if ($producto['stock'] < $cantidad) throw new Exception("Stock insuficiente para " . $producto['nombre']);

            $total = $producto['precio'] * $cantidad;

            // insertamos la venta
            $sqlVenta = "INSERT INTO ventas (producto_id, cantidad, total) VALUES (:p_id, :cant, :total)";
            $stmtVenta = $this->db->prepare($sqlVenta);
            $stmtVenta->execute([
                ':p_id' => $productoId,
                ':cant' => $cantidad,
                ':total' => $total
            ]);

            // 3. Restar el stock del producto
            $sqlStock = "UPDATE productos SET stock = stock - :cant WHERE id = :id";
            $stmtStock = $this->db->prepare($sqlStock);
            $stmtStock->execute([':cant' => $cantidad, ':id' => $productoId]);

            $this->db->commit(); // Confirmamos todo
            return ['ok' => true, 'mensaje' => 'Venta realizada con éxito'];

        } catch (Exception $e) {
            $this->db->rollBack(); // Si algo falla, deshacemos todo
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    public function listarVentas(): array {
        $sql = "SELECT v.id, p.nombre, v.cantidad, v.total, v.fecha_venta 
                FROM ventas v 
                JOIN productos p ON v.producto_id = p.id 
                ORDER BY v.fecha_venta DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}