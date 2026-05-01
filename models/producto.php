<?php
require_once __DIR__ . '/../config/database.php';

class Producto {
    private $db;

    public function __construct() {
        // Instanciamos la conexión
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // LISTAR: Obtener todos los productos
    public function listar() {
        $query = "SELECT id, nombre, precio, stock, creado_en FROM productos ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREAR: Insertar un producto con las validaciones que pide tu tarea
    public function crear($nombre, $precio, $stock) {
        // Validaciones del lado del servidor (el "Plus")
        if (empty($nombre)) return "El nombre no puede estar vacío";
        if ($precio <= 0) return "El precio debe ser mayor a 0";
        if ($stock < 0) return "El stock no puede ser negativo";

        $query = "INSERT INTO productos (nombre, precio, stock) VALUES (:nombre, :precio, :stock)";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':stock'  => $stock
        ]);
    }

    // ELIMINAR: Borrar por ID
    public function eliminar($id) {
        $query = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}