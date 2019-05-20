<?php 

class Usuario{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
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

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $this->db->real_escape_string($nombre);
        return $this;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $this->db->real_escape_string($apellidos);
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $this->db->real_escape_string($email);
        return $this;
    }

    public function getPassword()
    {
        return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
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

    /***************   *** Comentario *** ***************/
    /* @Descripcion: save()
    /* @Acción     : Guarda un nuevo usuario en la base de datos
    /***************   *** ********** *** ***************/
    public function save(){

        /***************   *** Comentario *** ***************/
        /* @Descripcion: Usando el metodo prepare en mysqli
        /* @Acción     : Limpiando las entradas
        /***************   *** ********** *** ***************/
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $email = $this->getEmail();
        $password = $this->getPassword();
        $rol = 'user';

        /***************   *** Comentario *** ***************/
        /* @Descripcion: Iniciamos preparando la accion de mysqli
        /* @Acción     : Insertar nuevos datos a un registro de la tabla usuarios.
        /***************   *** ********** *** ***************/

            $save = $this->db->prepare("INSERT INTO usuarios (nombre, apellidos, email, password, rol, fecha) VALUES (?,?,?,?,?,CURDATE())");
            $save->bind_param("sssss", $nombre,$apellidos,$email,$password,$rol);
            $save->execute();

            $result = false;
            if ($save) {
                $result = true;
                //se cierra la sentencia SQL
                $save->close();
            }
        
            return $result;
            
    
        

        /***************   *** Comentario *** ***************/
        /* @Descripcion: Metodo query
        /* @Acción     : No es muy seguro este metodo.
        /***************   *** ********** *** ***************/
        // $sql = "INSERT INTO usuarios VALUES(NULL,'{$this->getNombre()}','{$this->getApellidos()}','{$this->getEmail()}','{$this->getPassword()}','user',CURDATE(),NULL);";
        // $save = $this->db->query($sql);
        

        // $result = false;
        // if($save){
        //     $result = true;
        // }
        // return $result;
    }

    /***************   *** Comentario *** ***************/
    /* @Descripcion: login()
    /* @Acción     : Metodo para el login de un usuario ya registrado
    /***************   *** ********** *** ***************/
    public function login(){
        $result = false;
        $email = $this->email;
        $password = $this->password;

        //Comprobar si existe el usuario
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $login = $this->db->query($sql);
    

        if($login && $login->num_rows == 1){
            $usuario = $login->fetch_object();

            //Verificar la contraseña
            $verify = password_verify($password, $usuario->password);
            
            if ($verify) {
                $result = $usuario;
            }
        }

        return $result;
    }
}