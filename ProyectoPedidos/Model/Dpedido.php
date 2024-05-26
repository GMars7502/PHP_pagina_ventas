<?php


class Dpedido{

    //conexion con BD
    private $conn;

    //Tabla usuarios
    private $db_table = "pedidos";

    //Columnas de la tabla usuarios
    public $id;
    public $Nombre_Producto;
    public $precio;
    public $descripcion;
    public $idCliente;
    public $cantidad;
    public $estado;
    public $fkUsuarios;
    public $fkPedido;
    public $fkproducto;


    //DB Connection
    public function __construct($db) {
        $this->conn = $db;
    }
    //Metodos de consulta
    //Traer todos los registros
    public function getPedidos() {
        $sqlQuery = "SELECT productos.Nombre_Producto, pedidos.idPedido, productos.Descripcion, detalles_pedidos.Cantidad, pedidos.Estado FROM detalles_pedidos
        INNER JOIN pedidos ON pedidos.idPedido = detalles_pedidos.fkPedido
        INNER JOIN productos ON productos.idProducto = detalles_pedidos.fkProducto";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getPedido($idCliente){
        $sqlQuery = "SELECT pedidos.idPedido, productos.Nombre_Producto, productos.Descripcion, detalles_pedidos.Cantidad, pedidos.Estado FROM detalles_pedidos
        INNER JOIN pedidos ON pedidos.idPedido = detalles_pedidos.fkPedido
        INNER JOIN productos ON productos.idProducto = detalles_pedidos.fkProducto
        WHERE pedidos.fkUsuarios = ? ";
        
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute([$idCliente]);
        return $stmt;
    }


    //agregar producto
    /*
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
    */


    //Crear un nuevo registro o ususario
    public function createPedido() {
        try {
            // Primero insertamos el pedido
            $sqlPedido = "INSERT INTO " . $this->db_table . " SET fkUsuarios = :IdCliente";
            $stmtPedido = $this->conn->prepare($sqlPedido);
            
            $stmtPedido->bindParam(":IdCliente", $this->fkUsuarios);
            $stmtPedido->execute();
            
            // Obtenemos el ID del pedido recién insertado
            $lastInsertId = $this->conn->lastInsertId();
            
            // Luego insertamos el detalle del pedido
            $sqlDetalle = "INSERT INTO detalles_pedidos 
            SET fkPedido = :fkPedido, fkProducto = :fkProducto, Cantidad = :cantidad";
            $stmtDetalle = $this->conn->prepare($sqlDetalle);
            
            $stmtDetalle->bindParam(":fkPedido", $lastInsertId);
            $stmtDetalle->bindParam(":fkProducto", $this->fkproducto);
            $stmtDetalle->bindParam(":cantidad", $this->cantidad);
            $stmtDetalle->execute();
    
            // Verificamos si se realizaron ambas inserciones correctamente
            return $stmtPedido->rowCount() > 0 && $stmtDetalle->rowCount() > 0;
            
        } catch(PDOException $e) {
            // Manejar el error
            // return error_log($e->getMessage());
            return false;
        }
    }

    //Actualizar un registro
    public function updatePedido() {
        $sqlQuery = "UPDATE detalles_pedidos 
                    SET 
                        cantidad = :cantidad
                    WHERE idDetalle = :id";
        $stmt = $this->conn->prepare($sqlQuery);
        //Sanitizar los datos
        $this->cantidad = htmlspecialchars(strip_tags($this->cantidad));
        $this->id = htmlspecialchars(strip_tags($this->id));
        //bindear(enlazar) datos
        $stmt->bindParam(":cantidad", $this->cantidad);
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


    //Eliminar pedido!!!!!!
    public function deleteProduct() {
     try{ 
        
            // Eliminar detalles del pedido asociados al producto
            $sqlDeleteDetalles = "DELETE FROM detalles_pedidos WHERE fkPedido = ?";
            $stmtDetalles = $this->conn->prepare($sqlDeleteDetalles);
            $stmtDetalles->bindParam(1, $this->id);
            $stmtDetalles->execute();
            
            // Eliminar el producto
            $sqlDeleteProducto = "DELETE FROM " . $this->db_table . " WHERE idPedido = ?";
            $stmtProducto = $this->conn->prepare($sqlDeleteProducto);
            $stmtProducto->bindParam(1, $this->id);
            $stmtProducto->execute();
            
            // Verificar si se eliminaron registros en ambas tablas
            return $stmtDetalles->rowCount() > 0 && $stmtProducto->rowCount() > 0;
            
    }catch(PDOException $e) {
        return false;
    }
    }

}



