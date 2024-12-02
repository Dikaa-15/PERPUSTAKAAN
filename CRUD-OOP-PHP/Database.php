<?php

class Database{
    private $host = 'localhost';
    private $password = '';
    private $dbname = 'perpustakaan_praktik';
    private $username = 'root';

    public $conn;

    public function getConnection(){
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e)
        {
            echo "Failled to connect to database" . $e->getMessage();
        }
        return $this->conn;
    }

}