<?php


include_once $_SERVER['DOCUMENT_ROOT'] . '/Config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Model/User.php';



 $database;
 $db;
 $items;

    


$database = new Database();
$db = $database->getConnection();
$items = new User($db);


        $data = json_decode(file_get_contents("php://input")); //body (json) de la peticion del cliente rest
        $items->Nombre = "manuel";
        $items->Apellido = "Restan";
        $items->Correo = "mauuel@gmail";
        $items->password = "123456";
        $items->createUser();

        echo $items->createUser();
        
        /*
        if($this->items->createUser()) {
            http_response_code(201); //ok
            echo json_encode(array("message" => "Usuario creado."));
            echo json_encode($this->items->createUser());
        } else {
            
            http_response_code(503); //service unavailable
            echo json_encode(array("message" => "No se pudo crear el usuario."));
        }
    
*/
