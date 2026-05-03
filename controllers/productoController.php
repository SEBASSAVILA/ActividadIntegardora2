<?php
require_once __DIR__ . '/../models/producto.php';

class productoController { // Mantenlo en minúsculas si así lo prefieres
    private $modelo;

    public function __construct() {
        $this->modelo = new Producto();
    }

    public function index() {
        return $this->modelo->listar();
    }

    public function procesar() {
        // Lógica de eliminar, editar y crear...
        if (isset($_GET['eliminar'])) {
            $this->modelo->eliminar((int)$_GET['eliminar']);
            header("Location: productos.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
                $this->modelo->editar((int)$_POST['id_edit'], $_POST['nombre'], (float)$_POST['precio'], (int)$_POST['stock']);
                header("Location: productos.php?success=editado");
                exit();
            } else {
                $this->modelo->crear($_POST['nombre'], (float)$_POST['precio'], (int)$_POST['stock']);
                header("Location: productos.php?success=creado");
                exit();
            }
        }
    }
}