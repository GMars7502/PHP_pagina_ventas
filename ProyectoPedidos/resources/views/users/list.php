<?php
session_start();
//verficar si hay una sesion activa
if(!isset($_SESSION['Nombre'])) {

    header('Location: /users/login'); 
    session_id(); //ruta de login
    exit;

}
// recibes la variable
$usuario_id=$_SESSION['Nombre']; // ¿o me equivoco? 
//Consumir el api rest
//cURL
$url = "http://proyectopedidos.io/api/v1/productos.php";
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
include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/header.php';
?>
<h1 class="title">Lista de Productos</h1>
<div class="tbl-container">
<input type="hidden" id="user-name" value="<?php echo isset($_SESSION['Nombre']) ? $_SESSION['Nombre'] : '' ?>">
    <!--<a class="button btnBlue" href="/users/create">Crear nuevo</a>-->
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Accion</th>
        </tr>
        <?php
        foreach($users["data"] as $user) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($user['idProducto']) .'</td>';
            echo '<td>' . htmlspecialchars($user['Nombre_Producto']) .'</td>';
            echo '<td>' . htmlspecialchars($user['Descripcion']) .'</td>';
            echo '<td> $' . htmlspecialchars($user['precio']) .'</td>';
            echo '<td>';
            echo '<button id="-increase" class="stepper-control" title="Mas" type="button">+</button>';
            echo '<div class="stepper-value">1</div>';
            echo '<button id="-idecrease" class="stepper-control" title="Menos" type="button" disabled>-</button>';      
            echo '</td>';
            echo '<td>';
            echo '<a id="del-user" class="button btnRed" href="#" data-id="'. htmlspecialchars($user['idProducto']) .'">Agregar</a>';
            echo '</tr>';
        }
        ?>
    </table>
</div>
<?php
//Agregar pie HTML
include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/footer.php';
?>