<?php

class User{

    //conexion con BD
    private $conn;
    //Tabla usuarios
    private $db_table = "usuarios";
    //Columnas de la tabla usuarios
    public $id;
    public $Nombre;
    public $Apellido;
    public $password;
    public $Correo;
    //DB Connection
    public function __construct($db) {
        $this->conn = $db;
    }
    //Metodos de consulta
    //Traer todos los registros
    public function getUsers() {
        $sqlQuery = "SELECT idCliente, Nombre, Apellido,  password, 
        Correo FROM " . $this->db_table ."";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }


    //Traer un solo registro por id
    public function getUser($id) {
        $sqlQuery = "SELECT idCliente, Nombre, Apellido, password, Correo  FROM " . $this->db_table ." WHERE idCliente = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($dataRow != null) {
            $this->Nombre = $dataRow['Nombre'];
            $this->Apellido = $dataRow['Apellido'];
            $this->password = $dataRow['password'];
            $this->Correo = $dataRow['Correo'];
        } else {
            return null;
        }
    }

    //Para login, en que se conecta con el nombre
    public function getUserByNombre($Nombre) {
        $sqlQuery = "SELECT idCliente, Nombre, password FROM " . $this->db_table ." WHERE Nombre = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $Nombre);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($dataRow)) {
            return null;
        }
        return $dataRow;
    }


    //Crear un nuevo registro o ususario
    public function createUser() {
        $sqlQuery = "INSERT INTO ". $this->db_table ." 
                    SET 
                        Nombre = :Nombre,
                        Apellido = :Apellido,
                        Correo = :Correo,
                        password = :password";
        $stmt = $this->conn->prepare($sqlQuery);
        //Sanitizar los datos
        $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
        $this->Apellido = htmlspecialchars(strip_tags($this->Apellido));
        $this->Correo = htmlspecialchars(strip_tags($this->Correo));
        //password_hasd 
        $this->password = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_DEFAULT);
        //bindear(enlazar) datos
        $stmt->bindParam(":Nombre", $this->Nombre);
        $stmt->bindParam(":Apellido", $this->Apellido);
        $stmt->bindParam(":Correo", $this->Correo);
        $stmt->bindParam(":password", $this->password);
        //Se ejecuta la consulta
        try {
            $stmt->execute();
            return $stmt->rowCount() > 0 ? true : false;
            
        } catch(PDOException $e) {
            //return error_log($e->getMessage());
            return false;
        }
    }
    //Actualizar un registro
    public function updateUser() {
        $sqlQuery = "UPDATE ". $this->db_table ." 
                    SET 
                        Nombre = :Nombre,
                        Apellido = :Apellido,
                        password = :password,
                        Correo = :Correo
                    WHERE idCliente = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        //Sanitizar los datos
        $this->Nombre = htmlspecialchars(strip_tags($this->Nombre));
        $this->Apellido = htmlspecialchars(strip_tags($this->Apellido));
        $this->password = password_hash(htmlspecialchars(strip_tags($this->password)), PASSWORD_DEFAULT);
        $this->Correo = htmlspecialchars(strip_tags($this->Correo));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bindear(enlazar) datos
        $stmt->bindParam(":Nombre", $this->Nombre);
        $stmt->bindParam(":Apellido", $this->Apellido);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":Correo", $this->Correo);
        $stmt->bindParam(":id", $this->id);
        //Se ejecuta la consulta
        try {
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            return false;
        }
        //$stmt->execute();
    }


    //Eliminar un usuario
    public function deleteUser() {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE idCliente = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        //Se ejecuta la consulta
        $stmt->execute();
        return $stmt->rowCount() > 0 ? true : false;
    }






}