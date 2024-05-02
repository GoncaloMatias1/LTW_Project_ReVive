<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');
$session = new Session();
$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = User::getUserLogIn($db, $email, $password);

    if ($user) {
        $session->startSession();
        $_SESSION['user_id'] = $user->id;  
        header("Location: ../pages/mainPage.php");
        exit();
    } else {
        echo "Invalid login credentials.";
    }
}
?>
