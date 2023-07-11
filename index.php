<?php

require 'controllers/userController.php';
$userController = new UserController();

if(isset($_POST['campoEmail']) && isset($_POST['campoSenha']))
    $userController->AuthenticationUser($_POST['campoEmail'], $_POST['campoSenha']);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MoneyManager</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="form-login">
    <form method="POST" class="login">
        <h4 class="tag-email">E-mail</h4>
        <input type="email" name="campoEmail" div="campo-email"><br>
        <h4 class="tag-senha">Senha</h4>
        <input type="password" name="campoSenha" div="campo-senha"><br>
        <button class="botao-entrar-login">Entrar</button><br>
        <a href="cadastroUsuario.html" class="botao-cadastrar">Clique aqui para se cadastrar!</a>
    </form>
</body>
</html>