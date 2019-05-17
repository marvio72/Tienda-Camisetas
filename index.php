<?php 

require_once 'autoload.php';
require_once 'config/parameters.php';
require_once 'views/layout/header.phtml';
require_once 'views/layout/sidebar.phtml';

function show_error(){
    $error = new ErrorController();
    $error->index();
}

if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'].'Controller';
}elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $nombre_controlador = CONTROLLER_DEFAULT;
}else{
    show_error();
    exit();
}

if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();

    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();
    }elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $action_default = ACTION_DEFAULT;
        $controlador->$action_default();
    }
    else{
        show_error();
    }
}else{
    show_error();
}

require_once 'views/layout/footer.phtml';