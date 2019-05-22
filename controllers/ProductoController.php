<?php
require_once 'models/producto.php';
class ProductoController{

    public function index(){
        // echo "Controlador Productos, Acción index";
        require_once 'views/producto/destacados.phtml';
    }

    public function gestion(){
        Utils::isAdmin();

        $producto = new Producto();
        $productos = $producto->getAll();

        require_once 'views/producto/gestion.phtml';
    }

    public function crear(){
        Utils::isAdmin();

        require_once 'views/producto/crear.phtml';
    }

    public function save(){
        Utils::isAdmin();

        if (isset($_POST)) {
            // var_dump($_POST);
            // die();
            $nombre      = isset($_POST['nombre']) ? $_POST['nombre']          : false;
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion']: false;
            $precio      = isset($_POST['precio']) ? $_POST['precio']          : false;
            $stock       = isset($_POST['stock']) ? $_POST['stock']            : false;
            $categoria   = isset($_POST['categoria']) ? $_POST['categoria']    : false;
            $imagen      = isset($_POST['imagen']) ? $_POST['imagen']          : false;

           
            //captura de datos en campos para que permanezcan hasta que sean ingresados a la
            //base de datos
            $campos = array();
            $campos['nombre'] = $nombre;
            $campos['descripcion'] = $descripcion;
            $campos['precio'] = $precio;
            $campos['stock'] = $stock;
            $campos['categoria'] = $categoria;
            // $campos['imagen'] = $imagen;
            

            // Validar los datos
            $errores = array();
            

            // echo gettype($stock);
            //Validar Campos

            if (!empty($nombre)) {
                $nombre = Utils::LimpiarDatos($nombre);
                $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
            }else{
                $errores['nombre'] = "El nombre no es válido";
            }

            if (!empty($descripcion)) {
                $descripcion = Utils::LimpiarDatos($descripcion);
                $descripcion = filter_var($descripcion,FILTER_SANITIZE_STRING);
            }

            if ($precio >= 0 && is_numeric($precio) && preg_match("/[0-9.]/", $precio)) {
                $precio = Utils::LimpiarDatos($precio);
                $precio = filter_var($precio,FILTER_VALIDATE_FLOAT);            
            }else{
                $errores['precio'] = "El precio no es válido";
            }

            if ($stock >= 0 && is_numeric($stock) && preg_match("/[0-9]/", $stock)) {
                $stock = Utils::LimpiarDatos($stock);
                $stock = filter_var($stock,FILTER_VALIDATE_INT);
            }else{
                $errores['stock'] = "El stock no es válido";
            }

            if (!empty($categoria) && is_numeric($categoria) && preg_match("/[0-9]/", $categoria)) {
                $categoria = Utils::LimpiarDatos($categoria);
                $categoria = filter_var($categoria, FILTER_SANITIZE_NUMBER_INT);
            }

            if ($nombre && $descripcion && ($precio || $precio == 0) && ($stock || $stock == 0) && $categoria && count($errores) == 0) {
                $producto = new Producto();
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setStock($stock);
                $producto->setCategoria_id($categoria);

                //Guardar la imagen
                $file = $_FILES['imagen'];
                $filename = $file['name'];
                $mimetype = $file['type'];

                if ($mimetype == "image/gif" || $mimetype == "image/png" || $mimetype == "image/jpeg" || $mimetype == "bmp" || $mimetype == "webp") {
                    if (!is_dir('upload/images')) {
                        mkdir('upload/images',0777,true);
                    }

                    move_uploaded_file($file['tmp_name'],'upload/images/'.$filename);
                    $producto->setImagen($filename);
                }

                //Guardar la información ya validada a la base de datos
                $save = $producto->save();


                if ($save) {
                    $_SESSION['producto'] = "complete";
                    //Cierra la conexion
                    $producto->db->close();
                } else {
                    $_SESSION['producto'] = "failed";
                }
                  
            } else {
                $_SESSION['producto'] = "failed";
                $_SESSION['errores'] = $errores;
                $_SESSION['campos'] = $campos;
            }
            
        }else{
            $_SESSION['producto'] = "failed";
        }
        
        if (count($errores) == 0) {
            header("Location:" . BASE_URL . 'producto/gestion');
        } else {
            header("Location:" . BASE_URL . 'producto/crear');
        }
    }
}
