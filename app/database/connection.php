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
            echo 'Conexão estabelecida com sucesso.';
        }catch(PDOException $erro){
            echo "Falha na conexão: " . $erro->getMessage();
        }
    }
}