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
        $this->nombre = $this->db->real_escape_string($nombre);
        return $this;
    }

    public function getAll(){
        $categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;
    }

    public function save(){
        /***************   *** Comentario *** ***************/
        /* @Descripcion: Usando el metodo prepare en mysqli
        /* @Acción     : Limpiando las entradas
        /***************   *** ********** *** ***************/
        $nombre = $this->getNombre();
        

        /***************   *** Comentario *** ***************/
        /* @Descripcion: Iniciamos preparando la accion de mysqli
        /* @Acción     : Insertar nuevos datos a un registro de la tabla usuarios.
        /***************   *** ********** *** ***************/

        $save = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        $save->bind_param("s", $nombre);
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