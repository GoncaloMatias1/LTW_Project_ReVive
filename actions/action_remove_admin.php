<?php


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

    if (Users::removeAdmin($db, $user_id)) {
        header("Location: ../pages/user_profile.php?user_id=" .$user_id);
        exit();
    } else {
        echo "Error removing admin.";
    }
} else {
    echo "Invalid request.";
}
?>