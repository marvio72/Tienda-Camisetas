<?php
require_once 'models/categoria.php';

class CategoriaController{
    public function index(){
        Utils::isAdmin();
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        

        require_once 'views/categoria/index.phtml';
    }

    public function crear(){
        Utils::isAdmin();
        require_once 'views/categoria/crear.phtml';
    }

    public function save(){
        Utils::isAdmin();

        if (isset($_POST)) {
    
            $nombre    = isset($_POST['nombre']) ? $_POST['nombre']      : false;
            

            //captura de datos en campos para que permanezcan hasta que sean ingresados a la
            //base de datos
            $campos = array();
            $campos['nombre'] = $nombre;
            

            //Validar los datos
            $errores = array();


            // Validar nombre
            if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
                $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
                $nombre = Utils::LimpiarDatos($nombre);
            } else {
                $errores['nombre'] = "El nombre no es válido";
            }


            if ($nombre && count($errores) == 0) {

                $categoria = new Categoria();
                $categoria->setNombre($nombre);
                
                $save = $categoria->save();
                /***************   *** Comentario *** ***************/
                /* @Descripcion: Metodo prepare en mysqli
                /* @Acción     : Cerrando la base de datos.
                /***************   *** ********** *** ***************/


                if ($save) {
                    $_SESSION['register'] = "complete";
                    //Cierra la conexion
                    $categoria->db->close();
                    
                } else {
                    $_SESSION['register'] = "failed";
                }
            } else {
                $_SESSION['register'] = "failed";
                $_SESSION['errores'] = $errores;
                $_SESSION['campos'] = $campos;
            }
            if (count($errores) == 0) {
                header("Location:" . BASE_URL . 'categoria/index');
            }else{
                header("Location:" . BASE_URL . 'categoria/crear');
            }
        }
    }
}
