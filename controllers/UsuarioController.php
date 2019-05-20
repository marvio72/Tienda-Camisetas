<?php 
require_once 'models/Usuario.php';

class UsuarioController{

    public function index(){
        echo "Controlador Usuarios, Acción index";
    }

    public function registro(){
        require_once 'views/usuario/registro.phtml';
    }

    /***************   *** Comentario *** ***************/
    /* @Descripcion: save() 
    /* @Acción     : Preparar todo los campos para ingresar datos en la base de datos
    /***************   *** ********** *** ***************/
    public function save(){

        if (isset($_POST)) {
            // var_dump($_POST);
            $nombre    = isset($_POST['nombre']) ? $_POST['nombre']      : false;
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos']: false;
            $email     = isset($_POST['email']) ? $_POST['email']        : false;
            $password  = isset($_POST['password']) ? $_POST['password']  : false;

            //captura de datos en campos para que permanezcan hasta que sean ingresados a la
            //base de datos
            $campos = array();
            $campos['nombre'] = $nombre;
            $campos['apellidos'] = $apellidos;
            $campos['email'] = $email;
            $campos['password'] = $password;

            //Validar los datos
            $errores = array();
            

            // Validar nombre
            if (!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)) {
                $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
                $nombre = Utils::LimpiarDatos($nombre);
            } else {
                $errores['nombre']="El nombre no es válido";
            }

            if (!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)) {
                $apellidos = filter_var($apellidos, FILTER_SANITIZE_STRING);
                $apellidos = Utils::LimpiarDatos($apellidos);               
            } else {
                $errores['apellidos']="El apellido no es válido";                
            }

            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                $email = Utils::LimpiarDatos($email);  
                $email = strtolower($email);    
            } else {
                $errores['email'] = "El email no es válido";
            }

            if (!empty($password)) {
                $password = filter_var($password, FILTER_SANITIZE_STRING);
                $password = Utils::LimpiarDatos($password);
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
                /***************   *** Comentario *** ***************/
                /* @Descripcion: Metodo prepare en mysqli
                /* @Acción     : Cerrando la base de datos.
                /***************   *** ********** *** ***************/
    

                if ($save) {
                    $_SESSION['register'] = "complete";
                    //Cierra la conexion
                    $usuario->db->close();
                } else {
                    $_SESSION['register'] = "failed";
                }
                
            } else {
                $_SESSION['register'] = "failed";
                $_SESSION['errores'] = $errores;
                $_SESSION['campos'] = $campos;
            }
            header("Location:" . BASE_URL . 'usuario/registro');
        }
    }

    /***************   *** Comentario *** ***************/
    /* @Descripcion: login()
    /* @Acción     : Ingreso de un usuario ya registrado
    /***************   *** ********** *** ***************/
    public function login(){
        if (isset($_POST)) {
            // Identificar al usuario
            
            $usuario = new Usuario();
            $usuario->setEmail($_POST['email']);
            $usuario->setPassword($_POST['password']);
            
            // Consulta a la base de datos
            $identity = $usuario->login();

            // Crear sesión
            if ($identity && is_object($identity)) {
                $_SESSION['identity'] = $identity;
                
                if ($identity->rol == 'admin') {
                    $_SESSION['admin'] = true;
                }
            } else {
                $_SESSION['error_login'] = 'Identificación fallida !!';
            }


            
            
        }
        header("Location:".BASE_URL);
    }

    /***************   *** Comentario *** ***************/
    /* @Descripcion: logout()
    /* @Acción     : Metodo para cerrar sesion.
    /***************   *** ********** *** ***************/
    public function logout(){
        if (isset($_SESSION['identity'])) {
            unset($_SESSION['identity']);
        }
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
        header ("Location:".BASE_URL);
    }
} //fin Clase