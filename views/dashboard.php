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
    <div class="container-fluid text-bg-dark">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <div class="col-md-3 mb-2 mb-md-0">
                <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
                    <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                </a>
            </div>

            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2 link-secondary">Início</a></li>
                <li><a href="#" class="nav-link px-2">Contas</a></li>
                <li><a href="#" class="nav-link px-2">Balanços</a></li>
            </ul>

            <div class="col-md-3 text-end">
                <a href="?logout=true" style="text-decoration: none;">Sair</a>
            </div>
        </header>
    </div>

    <h1>Balanço</h1>
    <ul>
        <?php foreach($finances as $finance): ?>
        <li>
            <?php echo $finance['balance']; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <form method="POST" action="dashboard.php">
        <input type="text" name="account_name" placeholder="Nova conta" required>
        <input type="text" name="account_value" placeholder="Valor da nova conta" required>
        <button type="submit">Adicionar</button>
    </form>
    <h1>Contas</h1>
    <ul>
        <?php foreach($accounts as $account): ?>
        <li>
            <?php echo $account['nameAccount'] . ' ' . 'R$' . $account['value']; ?>
            <?php if($account['accountPay'] == 0): ?>
                <form method="POST" action="dashboard.php">
                    <?php if(isset($account['ID'])): ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>