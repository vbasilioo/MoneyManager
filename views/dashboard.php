<?php
session_start();

if(!isset($_SESSION['logged']) || $_SESSION['logged'] !== true){
    header("Location: ./index.php");
    exit;
}

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: ./index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyManager</title>
</head>
<body>
    <div>Teste HTML</div>
    <a href="?logout=true">Sair</a>
</body>
</html>