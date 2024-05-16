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
        header('Location: ../pages/register.php?error=Passwords do not match.');
        exit();
    }

    // Check if email already exists
    $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        header('Location: ../pages/register.php?error=This email is already registered.');
        exit();
    }

    $is_admin = false;

    try {
        $registration_success = Users::insertUser($db, $name, $username, $email, $password, $is_admin);
        if ($registration_success) {
            header('Location: ../pages/login.php');
            exit();
        } else {
            header('Location: ../pages/register.php?error=Failed to register user.');
            exit();
        }
    } catch (PDOException $e) {
        header('Location: ../pages/register.php?error=Failed to register user.');
        exit();
    }
}
?>
