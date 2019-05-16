<?php 

class UsuarioController{

    public function index(){
        echo "Controlador Usuarios, Acción index";
    }

    public function registro(){
        require_once 'views/usuario/registro.phtml';
    }

    public function save(){
        if (isset($_POST)) {
            var_dump($_POST);
        }
    }
} 