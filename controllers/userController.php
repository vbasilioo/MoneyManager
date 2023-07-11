<?php

require './database/connection.php';

class UserController{
    // Atributos da classe
    private $ID;
    private $name;
    private $email;
    private $password;
    private $dateBirth;

    // Variáveis dos arquivos
    private $connection;

    public function __construct(){
        $this->connection = new Connection();
    }

    // Método para cadastrar um usuário
    public function CadasterUser($email, $password, $name, $dateBirth){
        $stmt = $this->connection->GetConnection()->prepare("INSERT INTO user (`email`, `password`, `name`, `dateBirth`) VALUES (?, ?, ?, ?)");
        $stmt->bindValue('s', $email, PDO::PARAM_STR);
        $stmt->bindValue('s', $password, PDO::PARAM_STR);
        $stmt->bindValue('s', $name, PDO::PARAM_STR);
        $stmt->bindValue('s', $dateBirth, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Método de Autenticação do usuário
    public function AuthenticationUser($email, $password){
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            // Atribui os campos email e senha pra variáveis
            $email = $_POST["campoEmail"];
            $password = $_POST["campoSenha"];
            
            // Busca o usuário no banco de dados
            $conn = $this->connection->GetConnection();
            $stmt = $conn->prepare("SELECT * FROM user WHERE `email`=:email AND `password`=:password");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->execute();

            // Pegar o usuário que estamos pesquisando, e salva na variável $user
            // Pode retorna um vazio ou alguma coisa
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user){
                session_start();
                $_SESSION['logged'] = true;
                header("Location: ./views/dashboard.php");
                exit;
            }
            else echo "Email ou senha inválidos";
        }
    }
}