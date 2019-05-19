<?php 

class Utils{

    /***************   *** Comentario *** ***************/
    /* @Descripcion: Metodo para borrar $_SESSION
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
    /* @Descripcion: Metodo para mostrar los errores en los campos de registros.
    /* @Acción     : Mestra errores al ingresar datos
    /***************   *** ********** *** ***************/

    public static function MostrarError($errores, $campo){
        $alerta = '';
        if(isset($errores[$campo]) && !empty($campo)){
            $alerta = "<div class='alerta alerta-error'>".$errores[$campo]."</div>";
        }

        return $alerta;
    }
}