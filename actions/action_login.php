<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');

$session = new Session();
$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = Users::getUserLogIn($db, $email, $password);

    if ($user) {
        
        $_SESSION['user_id'] = $user->id;
    
        $redirectPage = $_GET['redirect'] ?? 'mainPage';
        header("Location: ../pages/{$redirectPage}.php");
        exit();
    } else {
        header("Location: ../pages/login.php?error=invalid_credentials");
        exit();
    }
}
?>
