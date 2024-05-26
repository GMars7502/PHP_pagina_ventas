<?php








class Database {
    private $host = "127.0.0.1"; //"localhost";
    private $database_name = "sistemapedidos";
    private $username = "root";
    private $password = "";
    public $conn;

    //aqui se conecta la base de datos
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name,
                                    $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }


}