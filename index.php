<?php 

require_once 'autoload.php';

if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'].'Controller';
}else{
    echo "La pagina que buscas no existe1";
    exit();
}

if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();

    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();
    }else{
        echo "La pagina que buscas no existe2";
    }
}else{
    echo "La pagina que buscas no existe3";
}
