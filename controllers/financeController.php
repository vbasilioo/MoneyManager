<?php

require_once './database/connection.php';

class Finance{
    private $ID;
    private $balance;
    private $connection;

    public function __construct(){
        $this->connection = new Connection();
    }

    public function ShowFinances(){
        $stmt = $this->connection->GetConnection()->query("SELECT * FROM `finance` ORDER BY ID DESC");
        return $stmt->fetchAll();
    }
}