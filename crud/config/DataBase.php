<?php
class DataBase {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "adote_pet3";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli(hostname: $this->host, username: $this->user, password: $this->password, database: $this->dbname);

        if ($this->conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $this->conn->connect_error);
        }
    }

    public function getConnection(): mysqli {
        return $this->conn;
    }

    public function closeConnection(): void {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
