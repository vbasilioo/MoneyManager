<?php

require_once './database/connection.php';

class Finance{
    private $ID;
    private $balance;
    private $connection;

    public function __construct(){
        $this->connection = new Connection();
    }

    public function ShowFinances($IDuser){
        $conn = $this->connection->GetConnection();
        $stmt = $conn->prepare("SELECT * FROM `finance` WHERE `IDuser` = :IDuser");
        $stmt->bindValue(':IDuser', $IDuser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBalance($ID){
        $conn = $this->connection->GetConnection();
        $stmt = $conn->prepare("SELECT `balance` FROM `finance` WHERE `IDuser` = :ID");
        $stmt->bindValue(':ID', $ID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paymentAccount($IDuser){
        $conn = $this->connection->GetConnection();
        $stmt = $conn->prepare("UPDATE `account` SET `accountPay` = 1 WHERE `IDuser` = :IDuser");
        $stmt->bindValue('IDuser', $IDuser, PDO::PARAM_INT);
        $stmt->execute();
    }
}