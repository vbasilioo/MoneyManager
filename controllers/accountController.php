<?php

require_once './database/connection.php';

class AccountController{
    //Atributos da classe
    private $ID;
    private $nameAccount;
    private $value;

    // Variáveis dos arquivos
    private $connection;
    private $financeController;

    public function __construct(){
        $this->connection = new Connection();
        $this->financeController = new Finance();
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

    public function PaymentAccount($ID){
        $conn = $this->connection->GetConnection();
        $stmt = $conn->prepare("SELECT `value` FROM `account` WHERE `ID` = :ID");
        $stmt->bindValue(':ID', $ID, PDO::PARAM_INT);
        $stmt->execute();
        $value = $stmt->fetchColumn();

        $balance = $this->financeController->getBalance($_SESSION['user_id'])[0]['balance'];
        $total = $balance - $value;

        $stmt = $conn->prepare("UPDATE `finance` SET `balance` = :total WHERE `IDuser` = :IDuser");
        $stmt->bindValue(':IDuser', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':total', $total, PDO::PARAM_STR);
        $stmt->execute();

        $this->financeController->paymentAccount($_SESSION['user_id']);  
    }
}

?>