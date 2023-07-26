<?php

require_once('controllers/userController.php');
$userController = new UserController();

if(isset($_POST['campoUsuario']) && isset($_POST['campoEmail']) && isset($_POST['campoSenha']) && $_POST['campoNascimento']){
    $userController->CadasterUser($_POST['campoEmail'], $_POST['campoSenha'], $_POST['campoUsuario'], $_POST['campoNascimento']);

    $mensagem = "Usuário cadastrado com sucesso!";
    echo '<script>
        setTimeout(function() {
            window.location.href = "../index.php";
        }, 3000);
    </script>';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>MoneyManager</title>
</head>
<body>
<style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');

        body{
            font-family: 'Poppins', sans-serif;
            background-color: slategrey;
        }

        .box-area{
            width: 530px;
        }

        .right-box{
            padding: 40px 30px 40px 40px;
        }

        ::placeholder{
            font-size: 16px;
        }

        @media only screen and (max-width: 768px){
            .box-area{
                margin: 0 10px;
            }

            .left-box{
                height: 100px;
                overflow: hidden;
            }

            .right-box{
                padding: 20px;
            }
        }
    </style>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounder-5 p-3 bg-white shadow box-area">
            <div class="col-md-12">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2 style="text-align: center;"><b>MoneyManager</b></h2>
                        <p style="text-align: center;">Cadastre-se</p>
                    </div>
                    <form method="POST" action="">
                        <?php if(isset($mensagem)) echo '<span style="color: green;align-items: center;justify-content: center;font-weight: bold;">' . $mensagem . '</span>'; ?>
                        <div class="input-group mb-3">
                            <input type="text" name="campoUsuario" class="form-control form-control-lg bg-light fs-6" placeholder="Usuário" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" name="campoEmail" class="form-control form-control-lg bg-light fs-6" placeholder="E-mail" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="campoSenha" class="form-control form-control-lg bg-light fs-6" placeholder="Senha" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="date" name="campoNascimento" class="form-control form-control-lg bg-light fs-6" placeholder="Data de Nascimento" required>
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Cadastrar</button>
                        </div>
                        <div class="row">
                        <small>
                            Já possui uma conta? <a href="../index.php">Entre</a>!
                        </small>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>