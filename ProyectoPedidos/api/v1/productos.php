<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Controllers/ProductoController.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $producto = new ProductoController();
        //traer un solo usuario por id
        //$ide;traer un solo usuario por id
        if(isset($_GET['id'])) {
            $producto->readOne($_GET['id']);
        } else {
            //traer todos los usuarios
            $producto->read();
        }
        break;
    case 'PUT':
            $producto = new ProductoController();
            //Actualiza el Api Token
            if(isset($_GET['update']) && $_GET['update'] === 'token') {
            } else {
                //Actualizar datos del usuario
                $producto->update();
            }
            break;
    case 'POST':
        $producto = new ProductoController();
        if(isset($_GET['login'])) {
            //login de usuario
            //$producto->login();
        } else {
            //crear usuario nuevo
            $producto->create();
        }
        break;
    case 'DELETE':
        $producto = new ProductoController();
        //Eliminar usuario
        $producto->delete();
        break;
    default:
        http_response_code(503);
        echo json_encode(array("error" => "Método no válido"));
        break;
}

?>
