<?php 

class Pedido{
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;
    public  $db;

    public function __construct(){
        $this->db = Database::connect();
    }



    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getUsuario_id()
    {
        return $this->usuario_id;
    }

    public function setUsuario_id($usuario_id)
    {
        $this->usuario_id = $usuario_id;
        return $this;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $this->db->real_escape_string($provincia);
        return $this;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }

    public function setLocalidad($localidad)
    {
        $this->localidad = $this->db->real_escape_string($localidad);
        return $this;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $this->db->real_escape_string($direccion);
        return $this;
    }

    public function getCoste()
    {
        return $this->coste;
    }

    public function setCoste($coste)
    {
        $this->coste = $coste;
        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
        return $this;
    }

    public function getAll()
    {
        $productos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC");
        return $productos;
    }

    public function getOne()
    {
        $id = $this->getId();
        // $producto = $this->db->query("SELECT * FROM pedidos WHERE id = $id");
        $sql = "SELECT p.*, u.nombre, u.apellidos , u.email FROM pedidos p "
             . "INNER JOIN usuarios u ON u.id = p.usuario_id "
             . "WHERE p.id = $id";
           
        $producto = $this->db->query($sql);


        return $producto->fetch_object();
    }

    public function getOneByUser()
    {
        $id_user = $this->getUsuario_id();
        $sql = "SELECT p.id, p.coste FROM pedidos p "
            //  . "INNER JOIN lineas_pedidos lp ON lp.pedido_id = p.id "     
             . "WHERE p.usuario_id = $id_user ORDER BY id DESC LIMIT 1";
            
        $pedido = $this->db->query($sql);

        return $pedido->fetch_object();
    }

    public function getAllByUser()
    {
        $id_user = $this->getUsuario_id();
        $sql = "SELECT p.* FROM pedidos p "   
            . "WHERE p.usuario_id = $id_user ORDER BY id DESC";

        $pedido = $this->db->query($sql);

        return $pedido;
    }

    public function getProductsByPedido($id){
        // $sql = "SELECT * FROM productos WHERE id IN "
        //      . "(SELECT producto_id FROM lineas_pedidos WHERE pedido_id={$id})";
        
        $sql = "SELECT pr.* , lp.unidades FROM productos pr "
             . "INNER JOIN  lineas_pedidos lp ON pr.id = lp.producto_id "
             . "WHERE pedido_id = {$id}";

        $productos = $this->db->query($sql);

        return $productos;
    }

    public function save()
    {
        $usuario_id = $this->getUsuario_id();
        $provincia  = $this->getProvincia();
        $localidad  = $this->getLocalidad();
        $direccion  = $this->getDireccion();
        $coste      = $this->getCoste();
        $estado     = $this->getEstado();
        $fecha      = $this->getFecha();
        $hora       = $this->getHora();


        $sql = "INSERT INTO pedidos VALUES (NULL,$usuario_id,'$provincia','$localidad','$direccion',$coste,'Confirmado',CURDATE(),CURTIME());"; 
        $save = $this->db->query($sql);
        
        $result = false;
        if ($save) {
            $result = true;
        }

        return $result;
    }

    public function save_linea(){
        $sql = "SELECT LAST_INSERT_ID() as 'pedido';";
        $query = $this->db->query($sql);
        $pedido_id = $query->fetch_object()->pedido;

        foreach ($_SESSION['carrito'] as $elemento) {
            $producto = $elemento['producto'];

            $insert = "INSERT INTO lineas_pedidos VALUES(NULL,{$pedido_id}, {$producto->id}, {$elemento['unidades']});";
            $save = $this->db->query($insert);

        }
        
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;

        var_dump($pedido_id);

        
    }

}
