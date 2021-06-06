<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'api_test';
    private $username = 'root';
    private $password = 'toor123';
    private $conn;
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:dbname=' . $this->db_name . ';host=' . $this->host,
            $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Eroor: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
