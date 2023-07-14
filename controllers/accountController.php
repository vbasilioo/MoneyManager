<?php

require_once './database/connection.php';

class AccountController{
    //Atributos da classe
    private $ID;
    private $nameAccount;
    private $value;

    // Variáveis dos arquivos
    private $connection;

    public function __construct(){
        $this->connection = new Connection();
    }

    // Método para cadastrar uma conta
    public function CadasterAccount($nameAccount, $value, $idUser){
        $stmt = $this->connection->GetConnection()->prepare("INSERT INTO account (`nameAccount`, `value`, `IDuser`) VALUES (?, ?, ?)");
        $stmt->bindValue(1, $nameAccount, PDO::PARAM_STR);
        $stmt->bindValue(2, $value, PDO::PARAM_STR);
        $stmt->bindValue(3, $idUser, PDO::PARAM_INT);
        $stmt->execute();
    }

    //Método para mostrar contas
    public function ShowAccounts($IDuser){
        $conn = $this->connection->GetConnection();
        $stmt = $conn->prepare("SELECT * FROM `account` WHERE `IDuser` = :IDuser");
        $stmt->bindValue(':IDuser', $IDuser, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function PaymentAccount($value, $id){
        $conn = $this->connection->GetConnection();
        $stmt = $conn->prepare("UPDATE `account` SET `value` = :value, `accountPay` = 1 WHERE `ID` = :id");
        $stmt->bindValue(':value', $value, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

?>