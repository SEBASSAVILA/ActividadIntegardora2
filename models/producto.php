<?php
require_once __DIR__ . '/../config/database.php';

class Producto {
    private  $db;

    public function __construct() {
        // Usamos el metodo estático de tu clase Database
        $this->db = Database::getConnection(); 
    }

    // Método para leer todos los productos
    public function listar(): array {
        $stmt = $this->db->prepare(
            "SELECT id, nombre, precio, stock, creado_en 
             FROM productos ORDER BY id DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(); 
    }

    // Metodo para insertar con validaciones profesionales
    public function crear(string $nombre, float $precio, int $stock): array {
        $nombre  = trim($nombre);
        $errores = [];

        if ($nombre === '') $errores[] = 'El nombre no puede estar vacío.';
        if (strlen($nombre) > 100) $errores[] = 'El nombre no puede superar 100 caracteres.';
        if ($precio <= 0) $errores[] = 'El precio debe ser mayor a 0.';
        if ($stock < 0) $errores[] = 'El stock no puede ser negativo.';

        if ($errores) return ['ok' => false, 'errores' => $errores];

        $stmt = $this->db->prepare(
            "INSERT INTO productos (nombre, precio, stock) 
             VALUES (:nombre, :precio, :stock)"
        );

        $stmt->execute([
            ':nombre' => htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'),
            ':precio' => round($precio, 2),
            ':stock'  => $stock,
        ]);

        return ['ok' => true, 'id' => (int) $this->db->lastInsertId()];
    }

    // Metodo para borrar
    public function eliminar(int $id): bool {
        if ($id <= 0) return false;
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
    //Meto de editar
    public function editar($id, $nombre, $precio, $stock) {
    $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, stock = :stock WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':stock', $stock);
    return $stmt->execute();
    }
    
}