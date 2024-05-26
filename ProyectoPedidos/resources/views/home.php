<?php
session_start();
//verficar si hay una sesion activa
if(!isset($_SESSION['Nombre'])) {
    header('Location: /users/login'); //ruta de login
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/header.php';

echo '<h1 class="title">Bienvenido, '. $_SESSION['Nombre'] .'</h1>';
echo '<a class="button btnGreen" href="/users/logout">Cerrar sesión</a>';

include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/footer.php';