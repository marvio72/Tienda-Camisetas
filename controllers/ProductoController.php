<?php
require_once 'models/producto.php';
class ProductoController{

    public function index(){
        // echo "Controlador Productos, Acción index";
        require_once 'views/producto/destacados.phtml';
    }

    public function gestion(){
        Utils::isAdmin();

        $producto = new Producto();
        $productos = $producto->getAll();

        require_once 'views/producto/gestion.phtml';
    }
}
