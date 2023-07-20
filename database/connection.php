<?php

class Connection{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "dbmm";
    private $conn;

    public function __construct(){
        try{
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Cria as tabelas, se não existirem no banco de dados
            $this->CreateTableUser();
            $this->CreateTableFinance();
            $this->CreateTableAccount();
        }catch(PDOException $erro){
            echo "Falha na conexão: " . $erro->getMessage();
        }
    }

    // Cria a tabela de 'usuários'
    public function CreateTableUser(){
        $sql = "CREATE TABLE IF NOT EXISTS user (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            `email` VARCHAR(50) NOT NULL,
            `password` VARCHAR(30) NOT NULL,
            `name` VARCHAR(50) NOT NULL,
            `dateBirth` VARCHAR(12) NOT NULL,
            `IDfinance` INT NOT NULl
            )";
        
        if($this->conn->query($sql) === false)
            die("Erro ao criar a tabela 'user'.");
    }

    // Cria a tabela de 'contas'
    public function CreateTableAccount(){
        $sql = "CREATE TABLE IF NOT EXISTS account (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            `nameAccount` VARCHAR(50) NOT NULL,
            `value` FLOAT NOT NULL,
            `accountPay` INT NOT NULL,
            `IDuser` INT NOT NULL
        )";

    if($this->conn->query($sql) === false)
        die("Erro ao criar a tabela 'account'.");
    }

    // Cria a tabela de 'finanças'
    public function CreateTableFinance(){
        $sql = "CREATE TABLE IF NOT EXISTS finance (
            ID INT AUTO_INCREMENT PRIMARY KEY,
            `balance` FLOAT NOT NULL,
            `IDuser` INT NOT NULL
            )";
        
        if($this->conn->query($sql) === false)
            die("Erro ao criar a tabela 'finance'.");
    }

    // Retorna a conexão do banco de dados
    public function GetConnection(){
        return $this->conn;
    }

    // Fecha a conexão com o banco de dados
    public function CloseConnection(){
        $this->conn = null;
    }
}