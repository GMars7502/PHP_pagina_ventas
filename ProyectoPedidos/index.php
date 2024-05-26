<?php 
//Autocarga de clases
spl_autoload_register(function ($class_name) {
   include 'Controllers/' . $class_name . '.php';
});
//Captura la URL Solicitada
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//Basado en la URL, se determina que controlador y metodo se ejecutará
switch($url) {
    case '/':
        require $_SERVER['DOCUMENT_ROOT'] . '/resources/views/home.php';
        break;
    case '/pedido';
        require $_SERVER['DOCUMENT_ROOT'] . '/resources/views/pedidos/list2.php';
        break;
    case '/users':
        require $_SERVER['DOCUMENT_ROOT'] . '/resources/views/users/list.php';
        break;
    case '/users/create':
    case '/users/update':
        require $_SERVER['DOCUMENT_ROOT'] . '/resources/views/users/actions.php';
        break;
    case '/users/login':
        require $_SERVER['DOCUMENT_ROOT'] . '/resources/views/users/login.php';
        break;
    case '/users/logout':
        require $_SERVER['DOCUMENT_ROOT'] . '/resources/views/users/logout.php';
        break;
    default:
        //cargar la vista de error 404
        require $_SERVER['DOCUMENT_ROOT'] . '/resources/views/404.php';
        break;
}
?>