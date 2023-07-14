<?php

require_once('controllers/userController.php');
require_once('controllers/financeController.php');
require_once('controllers/accountController.php');

session_start();

if(!isset($_SESSION['logged']) || $_SESSION['logged'] !== true){
    header("Location: index.php");
    exit;
}

if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit;
}

$userController = new UserController();

$financeController = new Finance();
$finances = $financeController->ShowFinances();

$accountController = new AccountController();
$accounts = $accountController->ShowAccounts($_SESSION['user_id']);

if(isset($_POST['account_name']) && isset($_POST['account_value'])){
    $accountController->CadasterAccount($_POST['account_name'], $_POST['account_value'], $_SESSION['user_id']);
    header("Location: dashboard.php");
}

if(isset($_POST['accountPay'])){
    $accountController->PaymentAccount($account['value'], $_POST['account_id']);
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyManager</title>
</head>
<body style="background-color: #80A56D;">
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
                    <input type="hidden" name="account_id" value="<?php echo $account['ID']; ?>">
                    <button type="submit" name="accountPay">Pagar conta</button>
                </form>
            <?php else: ?>
                <b>(Conta paga)</b>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <a href="?logout=true">Sair</a>
</body>
</html>