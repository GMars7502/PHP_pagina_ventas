<?php
session_start();
//Eliminar todas las variables de sesion
$_SESSION = array();
//Destruye la sesion
session_destroy();
//redirigir a la pagina de inicio (home.php)
header('Location: /');
exit;