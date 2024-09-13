<?php
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    private $dbname = "planilla";
    protected $conn;

    public function __construct() {
        // Crear la conexión
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Comprobar la conexión
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Método para cerrar la conexión
    public function close() {
        $this->conn->close();
    }
}
?>
