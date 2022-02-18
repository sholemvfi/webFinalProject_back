<?php

namespace config;
use PDO;
use PDOException;

class Database{

    private $server = 'localhost';
    private $db_name = 'movie';
    private $username = 'root';
    private $password = '';
    private $connection;

    public function connectingPdo(){
        $this->connection = null;
        try {
            $this->connection = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'not connected' . $e->getMessage();
        }
        return $this->connection;
    }
}

