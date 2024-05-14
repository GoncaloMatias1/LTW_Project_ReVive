<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');
require_once(__DIR__ . '/../database/categories.class.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    if (Category::addCategory($db, $category_name)) {
        header("Location: ../pages/categories.php?msg=CategoryAdded");
        exit();
    } else {
        echo "Error adding category.";
    }
} else {
    echo "Invalid request.";
}


?>