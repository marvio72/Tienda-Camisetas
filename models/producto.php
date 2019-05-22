<?php 

class Producto{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;
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

    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $this->db->real_escape_string($categoria_id);
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);
        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $this->db->real_escape_string($descripcion);
        return $this;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio)
    {
        $this->precio = $this->db->real_escape_string($precio);
        return $this;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $this->db->real_escape_string($stock);
        return $this;
    }

    public function getOferta()
    {
        return $this->oferta;
    }

    public function setOferta($oferta)
    {
        $this->oferta = $this->db->real_escape_string($oferta);
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

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
        return $this;
    }

    public function getAll(){
        $productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
        return $productos;
    }

    public function save()
    {
 
        /***************   *** Comentario *** ***************/
        /* @Descripcion: Usando el metodo prepare en mysqli
        /* @Acción     : Limpiando las entradas
        /***************   *** ********** *** ***************/
        $categoria   = $this->getCategoria_id();
        $nombre      = $this->getNombre();
        $descripcion = $this->getDescripcion();
        $precio      = $this->getPrecio();
        $stock       = $this->getStock();
        $oferta      = $this->getOferta();
        $fecha       = $this->getFecha();
        $imagen      = $this->getImagen();



        /***************   *** Comentario *** ***************/
        /* @Descripcion: Iniciamos preparando la accion de mysqli
        /* @Acción     : Insertar nuevos datos a un registro de la tabla usuarios.
        /***************   *** ********** *** ***************/

        $save = $this->db->prepare("INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES (?,?,?,?,?,NULL,CURDATE(),?)");
        $save->bind_param("issdis", $categoria,$nombre,$descripcion,$precio,$stock,$imagen);
        $save->execute();
        

        $result = false;
        if ($save) {
            $result = true;
            //se cierra la sentencia SQL
            $save->close();
        }

        return $result;
    }

}