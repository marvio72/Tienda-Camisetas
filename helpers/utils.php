<?php 

class Utils{

    /***************   *** Comentario *** ***************/
    /* @Descripcion: DeleteSesion
    /* @Acción     : Borrar $_SESSION[$name]
    /***************   *** ********** *** ***************/
    public static function DeleteSession($name){

        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }

        return $name;
    }

    /***************   *** Comentario *** ***************/
    /* @Descripcion: MostrarError
    /* @Acción     : Mestra errores al ingresar datos
    /***************   *** ********** *** ***************/

    public static function MostrarError($errores, $campo){
        $alerta = '';
        if(isset($errores[$campo]) && !empty($campo)){
            $alerta = "<div class='alerta alerta-error'>".$errores[$campo]."</div>";
        }

        return $alerta;
    }


    /***************   *** Comentario *** ***************/
    /* @Descripcion: LimpliarDatos
    /* @Acción     : Limpiar espacios blancos, caracteres especiales y quita la barra de un 
    /*                string con comillas escapadas.
    /***************   *** ********** *** ***************/

    public static function LimpiarDatos($datos){
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }

    /***************   *** Comentario *** ***************/
    /* @Descripcion: isAdmin
    /* @Acción     : Valida si el usuario es administrador
    /***************   *** ********** *** ***************/

    public static function isAdmin(){
        if (!isset($_SESSION['admin'])) {
            header("Location:".BASE_URL);
        }else {
            return true;
        }
    }

    /***************   *** Comentario *** ***************/
    /* @Descripcion: showCategorias
    /* @Acción     : Muestra en el menu todas las categorias que tenemos
    /***************   *** ********** *** ***************/

    public static function showCategorias(){
        require_once 'models/categoria.php';
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        return $categorias;
    }

    /***************   *** Comentario *** ***************/
    /* @Descripcion: mostrarDatos
    /* @Acción     : Muestra datos comprobando si son de la bd o de la captura del formulario
    /***************   *** ********** *** ***************/

    public static function mostrarDatos($campo){
        if (isset($_SESSION['cambiaValue']->$campo) && is_object($_SESSION['cambiaValue'])) {
            $resultado = isset($_SESSION['cambiaValue']) ? $_SESSION['cambiaValue']->$campo : '';
        }else{
            $resultado = isset($_SESSION['campos']) ? $_SESSION['campos'][$campo] : '';
        }
        return $resultado;
    }

    public static function statsCarrito(){
        $stats = array (
            'count' => 0,
            'total' => 0
        );

        if (isset($_SESSION['carrito'])) {
            $stats['count'] = count($_SESSION['carrito']);
            
            foreach ($_SESSION['carrito'] as $producto ) {
                $stats['total'] += $producto['precio']*$producto['unidades'];
            }
        }

        return $stats;
    }
        
}