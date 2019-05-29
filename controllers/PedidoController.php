<?php
require_once "models/pedido.php";

class PedidoController{

    public function hacer(){
        require_once 'views/pedido/hacer.phtml';
    } 

    public function add(){

        if (isset($_SESSION['identity'])) {
            $usuario_id = $_SESSION['identity']->id;
            $provincia  = isset($_POST['provincia']) ? $_POST['provincia']: false;
            $localidad  = isset($_POST['localidad']) ? $_POST['localidad']: false;
            $direccion  = isset($_POST['direccion']) ? $_POST['direccion']: false;

            if (!empty($usuario_id) && is_numeric($usuario_id) && preg_match("/[0-9]/",$usuario_id)) {
                $usuario_id = filter_var($usuario_id, FILTER_SANITIZE_NUMBER_INT);
                $usuario_id = Utils::LimpiarDatos($usuario_id);
            } else {
                $usuario_id = false;
            }
            
            if (!empty($provincia)) {
                $provincia = filter_var($provincia, FILTER_SANITIZE_STRING);
                $provincia = Utils::LimpiarDatos($provincia);
            } else {
                $provincia = false;
            }

            if (!empty($localidad)) {
                $localidad = filter_var($localidad, FILTER_SANITIZE_STRING);
                $localidad = Utils::LimpiarDatos($localidad);
            } else {
                $localidad = false;
            }

            if (!empty($direccion)) {
                $direccion = filter_var($direccion, FILTER_SANITIZE_STRING);
                $direccion = Utils::LimpiarDatos($direccion);
            } else {
                $direccion = false;
            }
            
            //Valor de Coste
            $stats = Utils::statsCarrito();
            $coste = $stats['total'];


            if ($provincia && $localidad && $direccion) {
                $pedido = new Pedido();
                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);

               
                $save = $pedido->save();

                //Guardar linea pedido
                $save_linea = $pedido->save_linea();

                if ($save && $save_linea) {
                    $_SESSION['pedido'] = "complete";
                    $pedido->db->close();
                    Utils::delete_carrito();
                }else{
                    $_SESSION['pedido'] = "failded";
                }

            }else{
                $_SESSION['pedido'] = "failded";
            }
            
            header("Location:".BASE_URL.'pedido/confirmado');
        }else{
            // Redirigir al index
            header("Location:".BASE_URL);
        }
    }

    public function confirmado(){
        if (isset($_SESSION['identity'])) {
            $identity = $_SESSION['identity'];
            // var_dump($identity);

            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);
            $pedido = $pedido->getOneByUser();

            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductsByPedido($pedido->id);
        }
        
        require_once 'views/pedido/confirmado.phtml';
    }

    public function mis_pedidos(){
        Utils::isIdentity();
        $usuario_id = $_SESSION['identity']->id;
        $pedido = new Pedido();
        
        //Sacar los pedidos del usuario
        $pedido->setUsuario_id($usuario_id);
        $pedidos = $pedido->getAllByUser();

        require_once 'views/pedido/mis_pedidos.phtml';
    }

    public function detalle(){
        Utils::isIdentity();
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            //Sacar los datos del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido = $pedido->getOne();

            //Sacar los productos del pedido
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductsByPedido($id);

            require_once 'views/pedido/detalle.phtml';
        }else{
            header('Location:'.BASE_URL.'pedido/mis_pedidos');
        }
    }

    public function gestion(){
        Utils::isAdmin();
        $gestion = true;

        $pedido = new Pedido();
        $pedidos = $pedido->getAll();


        require_once 'views/pedido/mis_pedidos.phtml';

    }

    public function estado(){
        Utils::isAdmin();
        if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
            $idped = $_POST['pedido_id'];
            $estado = $_POST['estado'];

            $pedido = new Pedido();
            $pedido->setId($idped);
            $pedido->setEstado($estado);
            $pedido->updateOne();

            header('Location:'.BASE_URL."pedido/detalle&id=$idped");
        }else{
            header("Location:".BASE_URL);
        }
    } 

}
