<?php 

class Categoria{
    private $id;
    private $nombre;
    public  $db ;

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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getAll(){
        $categorias = $this->db->query("SELECT * FROM categorias;");
        return $categorias;
    }
}