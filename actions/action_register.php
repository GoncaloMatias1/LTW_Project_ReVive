<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');

$session = new Session();
$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    $is_admin = false;
    $registration_success = Users::insertUser($db, $name, $username, $email, $password, $is_admin);

    if ($registration_success) {
        echo "User successfully registered.";
    } else {
        echo "Failed to register user.";
    }
}
?>
