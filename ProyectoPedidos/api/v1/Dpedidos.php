<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Controllers/DPedidoController.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $producto = new DpedidoController();
        //traer un solo usuario por id
        //$ide;traer un solo usuario por id
        if(isset($_GET['idCliente'])) {
            $producto->readOne($_GET['idCliente']);
        } 
        else {
            //debo agregar un id cliente para obtener los pedidos del cliente
            
            $producto->read();
        }
        break;
    case 'PUT':
            $producto = new DpedidoController();
            //Actualiza el Api Token
            if(isset($_GET['update']) && $_GET['update'] === 'token') {
            } else {
                //Actualizar datos del usuario
                $producto->update();
            }
            break;
    case 'POST':
        $producto = new DpedidoController();
        if(isset($_GET['login'])) {
            //login de usuario
            //$producto->login();
        } else {
            //crear usuario nuevo
            $producto->create();
        }
        break;
    case 'DELETE':
        $producto = new DpedidoController();
        //Eliminar usuario
        $producto->delete();
        break;
    default:
        http_response_code(503);
        echo json_encode(array("error" => "Método no válido"));
        break;
}

?>
