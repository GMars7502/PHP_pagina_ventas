<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once $_SERVER['DOCUMENT_ROOT'] . '/Config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Model/User.php';


class UserController {
    private $database;
    private $db;
    private $items;

    

    public function __construct() {
        $this->database = new Database();
        $this->db = $this->database->getConnection();
        $this->items = new User($this->db);
    }




    //Operaciones CRUD
    //traer todos los datos
    public function read() {

         
        header("Access-Control-Allow-Methods: GET");

        $stmt = $this->items->getUsers();
        $itemCount = $stmt->rowCount();

         if ($itemCount > 0) {
        $userData["data"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userData["itemCount"] = $itemCount;
        echo json_encode($userData);
          } else {
        http_response_code(404); // Not found
        echo json_encode(array("message" => "No hay datos."));
          }

          /*
        header("Access-Control-Allow-Methods: GET");

        $stmt = $this->items->getUsers();
        $itemCount = $stmt->rowCount();

        if($itemCount > 0) {
            $userData = array();
            $userData["data"] = array();
            $userData["itemCount"] = $itemCount;

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $u = array(
                    //"idCliente" => $id,
                    "Nombre" => $Nombre,
                    "Apellido" => $Apellido,
                    "Correo" => $Correo,
                    "password" => $password
                    
                );
                array_push($userData["data"], $u);
            }
            echo json_encode($userData);
        } else {
            http_response_code(404); //not found
            echo json_encode(
                array("message" => "No hay datos.")
            );
            */
        }
      
    
    //Login User
    public function login() {
        header("Access-Control-Allow-Methods: POST");
        $data = json_decode(file_get_contents("php://input"));

        if(!isset($data->Nombre) || !isset($data->password)) {
            http_response_code(400);
            echo json_encode(["error" => "Debe proporcionar Nombre y password"]);
            return;
        }
        //Consultar si existe el username
        $user = $this->items->getUserByNomBRE($data->Nombre);
        if(!$user) {
            http_response_code(404);
            echo json_encode(["error" => "El nombre no existe!"]);
            return;
        }
        //Verificar la contraseña
        if(!password_verify($data->password, $user['password'])) {
            http_response_code(401);
            echo json_encode(["error" => "Password incorrecto!"]);
            return;
        }
        
        //Iniciar las sesion del usuario
        session_start();
        //$_SESSION['datos'] = array();
        $_SESSION['Nombre'] = $user['idCliente']; 
        
        http_response_code(200);
        echo json_encode([
            'success' => 'true',
        ]);
    }






    
    //Traer un solo usuario por id
    public function readOne($id) {
        header("Access-Control-Allow-Methods: GET");

        $this->items->id = isset($_GET['id']) ? $_GET['id'] : die();
        $this->items->getUser($id);

        if($this->items->Nombre != null) {
            //crear un array con los datos del usuario
            $user_data = array(
                "id" => $this->items->id,
                "Nombre" => $this->items->Nombre,
                "password" => $this->items->password,
                "correo" => $this->items->Correo
            );

            http_response_code(200); //ok
            echo json_encode($user_data);
        } else {
            http_response_code(404); //not found
            echo json_encode(array("message" => "Usuario no existe."));
        }
    }


    //Crear un usuario
    public function create() {
        
            header("Access-Control-Allow-Methods: POST");
        $data = json_decode(file_get_contents("php://input")); //body (json) de la peticion del cliente rest
        $this->items->Nombre = $data->Nombre;
        $this->items->Apellido = $data->Apellido;
        $this->items->Correo = $data->Correo;
        $this->items->password = $data->password;
        
        if($this->items->createUser()) {
            http_response_code(201); //ok
            echo json_encode(array("message" => "Usuario creado."));
        } else {
            
            http_response_code(503); //service unavailable
            echo json_encode(array("message" => "No se pudo crear el usuario."));
        }
        
        
    }
    
    //Actualizar un usuario
    public function update() {
        header("Access-Control-Allow-Methods: PUT");

        $data = json_decode(file_get_contents("php://input"));
        //el id de referencia para actualizar el usuario
        $this->items->id = $data->id;
        //valores de usuario para actualizar
        $this->items->Nombre = $data->Nombre;
        $this->items->Apellido = $data->Apellido;
        $this->items->password = $data->password;
        $this->items->Correo = $data->Correo;

        if($this->items->updateUser()) {
            http_response_code(200); //ok
            echo json_encode(array("message" => "Datos de Usuario actualizados."));
        } else {
            http_response_code(503); //service unavailable
            echo json_encode(array("message" => "No se pudo actualizar el usuario."));
        }
    }
    //Actualizar Api Token

    
    //Eliminar un usuario
    public function delete() {
        header("Access-Control-Allow-Methods: DELETE");

        $data = json_decode(file_get_contents("php://input"));
        //el id de referencia para actualizar el usuario
        $this->items->id = $data->id;

        if($this->items->deleteUser()) {
            http_response_code(200); //ok
            echo json_encode(array("message" => "Usuario eliminado."));
        } else {
            http_response_code(503); //service unavailable
            echo json_encode(array("message" => "No se pudo procesar la eliminación del usuario."));
        }
    }
}



