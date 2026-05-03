<?php
require_once __DIR__ . '/../models/producto.php';

class ProductoController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Producto();
    }

    //para obtener los datos
    public function index() {
        return $this->modelo->listar();
    }

    
    public function procesar() {
        //  ELIMINA datos
        if (isset($_GET['eliminar'])) {
            $id = (int)$_GET['eliminar'];
            $this->modelo->eliminar($id);
            header("Location: productos.php");
            exit();
        }

        //  GUARDAR datos 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $precio = (float)$_POST['precio'];
            $stock = (int)$_POST['stock'];

            $this->modelo->crear($nombre, $precio, $stock);
            header("Location: productos.php");
            exit();
        }
    }
}