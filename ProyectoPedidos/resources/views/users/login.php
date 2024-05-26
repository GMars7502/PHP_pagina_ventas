<?php
include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/header.php';
?>
<div class="form-container">
    <h1 class="title">Login de Usuarios</h1>
    <form id="form-login" action="" method="post">
        <label for="Nombre">Nombre de usuario:</label>
        <input type="text" id="Nombre" name="Nombre" required>
        <span id="usernameError" style="color: red;"></span>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <span id="passwordError" style="color: red;"></span>
        <input type="submit" value="Iniciar sesión">
        <p>     No tienes cuenta? <a href="/users/create" Target="_self">regístrate</a></p>
    </form>
    
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/resources/views/layout/footer.php';
?>