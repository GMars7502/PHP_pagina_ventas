<?php

include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/header.php';
//Verificar la accion a realizar (create o update)
if(isset($_GET['id'])) {
    //Update user form
    $url = "http://proyectopedidos.io/api/v1/users.php?id=". $_GET['id'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    //Verificar errores en la peticion cURL
    if(curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    } else {
        $user = json_decode($response, true);
    }
    //Verificar si la decodificacion de datos fue exitosa
    if(json_last_error() !== JSON_ERROR_NONE) {
        echo 'Error al decodificar la respuesta JSON: ' . json_last_error_msg();
    }
    //cerramos la sesion cURL
    curl_close($ch);
    //Formulario de actualizacion
    echo '<div class="form-container">';
    echo '<h1 class="title">Editar información del Usuario</h1>';
    echo '<form id="form-update-user" action="" method="POST">';
    echo '<input type="hidden" name="id" value="'.htmlspecialchars($user['id']).'">';
    echo '<label for="username">Nombre de usuario:</label>';
    echo '<input type="text" id="username" name="username" value="'.htmlspecialchars($user['username']).'" required>';
    echo '<label for="email">Email:</label>';
    echo '<input type="text" id="email" name="email" value="'.htmlspecialchars($user['email']).'" required>';
    echo '<label for="password">Contraseña:</label>';
    echo '<input type="password" id="password" name="password" required>';
    echo '<label for="role">Rol:</label>';
    echo '<select id="role" name="role">';
        echo '<option value="USER"'.($user['role'] == 'USER' ? ' selected' : '').'>Usuario</option>';
        echo '<option value="ADMIN"'.($user['role'] == 'ADMIN' ? ' selected' : '').'>Administrador</option>';
    echo '</select>';
    echo '<input type="submit" value="Actualizar">';
    echo '</form>';
    echo '</div>';
} else {
    //Formulario de registro
    echo '<div class="form-container">';
    echo '<h1 class="title">Registrar nuevo Usuario</h1>';
    echo '<form id="form-create-user" action="" method="POST">';
    echo '<label for="Nombre">Nombre de usuario:</label>';
    echo '<input type="text" id="Nombre" name="Nombre" required>';
    echo '<label for="Apellido">Apellido de usuario:</label>';
    echo '<input type="text" id="Apellido" name="Apellido" required>';
    echo '<label for="Correo">Correo:</label>';
    echo '<input type="text" id="Correo" name="Correo" required>';
    echo '<label for="password">Contraseña:</label>';
    echo '<input type="password" id="password" name="password" required>';
    echo '<input type="submit" value="Registrar">';
    echo '</form>';
    echo '</div>';
}


include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/footer.php';



