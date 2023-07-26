<?php

require_once('controllers/userController.php');
require_once('controllers/financeController.php');
require_once('controllers/accountController.php');

session_start();

if(!isset($_SESSION['logged']) || $_SESSION['logged'] !== true){
    header("Location: ../index.php");
    exit;
}

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: ../index.php");
    exit;
}

$userController = new UserController();

$financeController = new Finance();
$finances = $financeController->ShowFinances($_SESSION['user_id']);

$accountController = new AccountController();
$accounts = $accountController->ShowAccounts($_SESSION['user_id']);

if(isset($_POST['account_name']) && isset($_POST['account_value'])){
    $accountController->CadasterAccount($_POST['account_name'], $_POST['account_value'], $_SESSION['user_id']);
    header("Location: dashboard.php");
}

if(isset($_POST['accountPay']) && isset($_POST['account_id'])){
    $accountController->PaymentAccount($_POST['account_id']);
    header("Location: dashboard.php");
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

        html, body{
            height: 100%;
        }

        body{
            background-color: slategrey;
            font-family: 'Poppins', sans-serif;
        }

        .custom-navbar {
            background-color: cornflowerblue; 
            border-radius: 0 0 25px 25px;
            width: 75%;
            margin: 0 auto;
        }

        .custom-navbar .navbar-collapse {
            justify-content: center;
        }

        .content-dashboard{
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    <nav class="navbar custom-navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="#" style="color: white;font-size: 18px;font-weight: bold;">Início</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="#" style="color: white;font-size: 18px;font-weight: bold;">Contas</a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="?logout=true" style="color: red;font-size: 18px;font-weight: bold;">Sair</a>
            </li>
        </ul>
    </nav>

    <div class="content-dashboard">
        <div class="content">
            <h1 style="text-align:center;">Balanço</h1>
            <ul class="finance-list">
                <?php foreach ($finances as $finance): ?>
                    <li style="list-style-type:none;font-size: 28px;font-weight: bold;text-align:center;"><?php echo $finance['balance']; ?></li>
                <?php endforeach; ?>
            </ul>

            <form method="POST" action="dashboard.php">
                <input type="text" name="account_name" placeholder="Nova conta" required>
                <input type="text" name="account_value" placeholder="Valor da nova conta" required>
                <button type="submit">Adicionar</button>
            </form>

            <h1 style="text-align:center;">Contas</h1>
            <ul class="account-list">
            <?php foreach ($accounts as $account): ?>
                <li>
                <?php echo $account['nameAccount'] . ' ' . 'R$' . $account['value']; ?>
                <?php if ($account['accountPay'] == 0): ?>
                    <form method="POST" action="dashboard.php">
                    <?php if (isset($account['ID'])): ?>
                        <input type="hidden" name="account_id" value="<?php echo $account['ID']; ?>">
                    <?php endif; ?>
                    <button type="submit" name="accountPay">Pagar conta</button>
                    </form>
                <?php else: ?>
                    <b>(Conta paga)</b>
                <?php endif; ?>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>