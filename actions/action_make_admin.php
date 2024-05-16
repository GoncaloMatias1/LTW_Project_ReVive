<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');


$session = new Session();
if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}


$db = getDatabaseConnection();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    if (Users::makeAdmin($db, $user_id)) {
        header("Location: ../pages/user_profile.php?user_id=" .$user_id);
        exit();
    } else {
        echo "Error making admin.";
    }
} else {
    echo "Invalid request.";
}
?>