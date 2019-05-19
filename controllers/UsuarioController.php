<?php 
require_once 'models/Usuario.php';

class UsuarioController{

    public function index(){
        echo "Controlador Usuarios, Acción index";
    }

    public function registro(){
        require_once 'views/usuario/registro.phtml';
    }

    public function save(){

        if (isset($_POST)) {
            // var_dump($_POST);
            $nombre    = isset($_POST['nombre']) ? $_POST['nombre']      : false;
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos']: false;
            $email     = isset($_POST['email']) ? $_POST['email']        : false;
            $password  = isset($_POST['password']) ? $_POST['password']  : false;

            //Validar los datos
            $errores = array();

            // Validar nombree
            if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
                $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
            } else {
                $errores['nombre']="El nombre no es válido";
            }

            if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
                $apellidos = filter_var($apellidos, FILTER_SANITIZE_STRING);
            } else {
                $errores['apellidos']="El apellido no es válido";
            }

            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            } else {
                $errores['email'] = "El email no es válido";
            }

            if (!empty($password)) {
                $password = filter_var($password, FILTER_SANITIZE_STRING);
            } else {
                $errores['password'] = "La contraseña no es válida";
            } 


            if ($nombre && $apellidos && $email && $password && count($errores)==0) {
                
                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                $usuario->setPassword($password);

                $save = $usuario->save();
                $conexion = new Usuario;
                /***************   *** Comentario *** ***************/
                /* @Descripcion: Metodo prepare en mysqli
                /* @Acción     : Cerrando la base de datos.
                /***************   *** ********** *** ***************/
    

                if ($save) {
                    $_SESSION['register'] = "complete";
                    //Cierra la conexion
                    $conexion->db->close();
                } else {
                    $_SESSION['register'] = "failed";
                }
                
            } else {
                $_SESSION['register'] = "failed";
                $_SESSION['errores'] = $errores;
            }
            header("Location:" . BASE_URL . 'usuario/registro');
        }
    }
} 