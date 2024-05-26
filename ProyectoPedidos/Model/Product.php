<?php

class Product{

    //conexion con BD
    private $conn;
    //Tabla usuarios
    private $db_table = "productos";
    //Columnas de la tabla usuarios
    public $id;
    public $Nombre_Producto;
    public $precio;
    public $descripcion;
    
    //DB Connection
    public function __construct($db) {
        $this->conn = $db;
    }
    //Metodos de consulta
    //Traer todos los productos
    public function getProductos() {
        $sqlQuery = "SELECT idProducto ,Nombre_Producto, Descripcion, precio FROM " . $this->db_table ."";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    //traer un solo producto
    //Traer un solo registro por id
    public function getProduct($id) {
        $sqlQuery = "SELECT idProducto, Nombre_Producto,Descripcion, precio FROM " . $this->db_table ." WHERE idProducto = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($dataRow != null) {
            $this->Nombre_Producto = $dataRow['Nombre_Producto'];
            $this->precio = $dataRow['Precio'];
            $this->descripcion = $dataRow['Descripcion'];
        } else {
            return null;
        }
    }



    //Crear un nuevo producto
    public function createProduct() {
        $sqlQuery = "INSERT INTO ". $this->db_table ." 
                    SET 
                        Nombre_Producto = :Nombre_Producto,
                        precio = :precio,
                        Descripcion= :descripcion";
        $stmt = $this->conn->prepare($sqlQuery);
        //Sanitizar los datos
        $this->Nombre_Producto = htmlspecialchars(strip_tags($this->Nombre_Producto));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        //bindear(enlazar) datos
        $stmt->bindParam(":Nombre_Producto", $this->Nombre_Producto);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":descripcion", $this->descripcion);
        //Se ejecuta la consulta
        try {
            $stmt->execute();
            return $stmt->rowCount() > 0;
            
        } catch(PDOException $e) {
            //return error_log($e->getMessage());
            return false;
        }
    }
    //Actualizar un registro
    public function updateProduct() {
        $sqlQuery = "UPDATE ". $this->db_table ." 
                    SET 
                        Nombre_Producto = :Nombre_Producto,
                        Descripcion = :descripcion,
                        precio = :precio
                    WHERE idProducto = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        //Sanitizar los datos
        $this->Nombre_Producto = htmlspecialchars(strip_tags($this->Nombre_Producto));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bindear(enlazar) datos
        $stmt->bindParam(":Nombre_Producto", $this->Nombre_Producto);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":descripcion", $this->descripcion);
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


    //Eliminar un registro
    public function deleteProduct() {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE idProducto = ?";
        $stmt = $this->conn->prepare($sqlQuery);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        //Se ejecuta la consulta
        $stmt->execute();
        return $stmt->rowCount() > 0 ? true : false;
    }



    




}