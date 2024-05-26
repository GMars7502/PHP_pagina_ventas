<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once $_SERVER['DOCUMENT_ROOT'] . '/Config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Model/Product.php';


class ProductoController {
    private $database;
    private $db;
    private $items;

    

    public function __construct() {
        $this->database = new Database();
        $this->db = $this->database->getConnection();
        $this->items = new Product($this->db);
    }
    


    //Operaciones CRUD
    //traer todos los datos
    public function read() {
        
        header("Access-Control-Allow-Methods: GET");

    $stmt = $this->items->getProductos();
    $itemCount = $stmt->rowCount();

    if ($itemCount > 0) {
        $userData["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userData["itemCount"] = $itemCount;
        echo json_encode($userData);
    } else {
        http_response_code(404); // Not found
        echo json_encode(array("message" => "No hay datos."));
    }
    
}   
    



    
    //Traer un solo usuario por id
    public function readOne($id) {
        header("Access-Control-Allow-Methods: GET");

        $this->items->id = $id;
        $this->items->getProduct($id);

        if($this->items->Nombre_Producto != null) {
            //crear un array con los datos del usuario
            $user_data = array(
                "idProducto" => $this->items->id,
                "Nombre_Producto" => $this->items->Nombre_Producto,
                "precio" => $this->items->precio,
                "descripcion" => $this->items->descripcion
            );

            http_response_code(200); //ok
            echo json_encode($user_data);
        } else {
            http_response_code(404); //not found
            echo json_encode(array("message" => "Producto no existe."));
        }
    }


    //Crear un usuario
    public function create() {
        
            header("Access-Control-Allow-Methods: POST");
        $data = json_decode(file_get_contents("php://input")); //body (json) de la peticion del cliente rest
        $this->items->Nombre_Producto = $data->Nombre_Producto;
        $this->items->precio = $data->precio;
        $this->items->descripcion = $data->descripcion;
        
        if($this->items->createProduct()) {
            http_response_code(201); //ok
            echo json_encode(array("message" => "Producto creado."));
        } else {
            
            http_response_code(503); //service unavailable
            echo json_encode(array("message" => "No se pudo crear el producto."));
        }
        
        
    }
    
    //Actualizar un usuario
    public function update() {
        header("Access-Control-Allow-Methods: PUT");

        $data = json_decode(file_get_contents("php://input"));
        //el id de referencia para actualizar el usuario
        $this->items->id = $data->id;
        //valores de usuario para actualizar
        $this->items->Nombre_Producto = $data->Nombre_Producto;
        $this->items->precio = $data->precio;
        $this->items->descripcion = $data->descripcion;

        if($this->items->updateProduct()) {
            http_response_code(200); //ok
            echo json_encode(array("message" => "Datos de productos actualizados."));
        } else {
            http_response_code(503); //service unavailable
            echo json_encode(array("message" => "No se pudo actualizar el producto."));
        }
    }
    //Actualizar Api Token

    
    //Eliminar un usuario
    public function delete() {
        header("Access-Control-Allow-Methods: DELETE");

        $data = json_decode(file_get_contents("php://input"));
        //el id de referencia para actualizar el usuario
        $this->items->id = $data->id;

        if($this->items->deleteProduct()) {
            http_response_code(200); //ok
            echo json_encode(array("message" => "Producto eliminado."));
        } else {
            http_response_code(503); //service unavailable
            echo json_encode(array("message" => "No se pudo procesar la eliminación del Producto."));
        }
    }
}



