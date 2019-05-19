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
}