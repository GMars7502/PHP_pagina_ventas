<?php 
session_start();
//verficar si hay una sesion activa
if(!isset($_SESSION['Nombre'])) {
    header('Location: /users/login'); //ruta de login
    exit;
}

$idcliente = $_SESSION['Nombre'];
//Consumir el api rest
//cURL
$url = "http://proyectopedidos.io/api/v1/Dpedidos.php?idCliente=" . $idcliente;
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
    $users = json_decode($response, true);
}
//Verificar si la decodificacion de datos fue exitosa
if(json_last_error() !== JSON_ERROR_NONE) {
    echo 'Error al decodificar la respuesta JSON: ' . json_last_error_msg();
}
//cerramos la sesion cURL
curl_close($ch);
//Agregar encabezado HTML
include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/header2.php';
?>
<h1 class="title">Lista de Pedidos</h1>
<div class="tbl-container">
    
    <table>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php
        if (empty($users["data"])) {
            // La variable $users["data"] está vacía
            echo '<tr>';
            echo '<td> No se encontraron datos </td>';
            echo '</tr>';
        } else {
        foreach($users["data"] as $user) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($user['idPedido']) .'</td>';
            echo '<td>' . htmlspecialchars($user['Nombre_Producto']) .'</td>';
            echo '<td>' . htmlspecialchars($user['Descripcion']) .'</td>';
            echo '<td>' . htmlspecialchars($user['Cantidad']) .'</td>';
            echo '<td>' . htmlspecialchars($user['Estado']) .'</td>';
            echo '<td>';
            echo '<a id="del-user" class="button btnRed" href="#" data-id="'. htmlspecialchars($user['idPedido']) .'">Borrar</a>';
            echo '</td>';
            echo '</tr>';
        }}
        ?>
    </table>
</div>
<?php
//Agregar pie HTML
include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/footer2.php';


?>







