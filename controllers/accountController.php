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
    public function CadasterAccount($nameAccount, $value){
        $stmt = $this->connection->GetConnection()->prepare("INSERT INTO account (`nameAccount`, `value`) VALUES (?, ?)");
        $stmt->bindValue(1, $nameAccount, PDO::PARAM_STR);
        $stmt->bindValue(2, $value, PDO::PARAM_STR);
        $stmt->execute();
    }

    //Método para mostrar contas
    public function ShowAccounts(){
        $conn = $this->connection->GetConnection();
        $stmt = $conn->prepare("SELECT * FROM `account`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>