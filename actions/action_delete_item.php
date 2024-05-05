<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $itemId = intval($_POST['item_id']);
    $userId = $_SESSION['user_id']; 

    if (Item::deleteItem($db, $itemId, $userId)) {
        header("Location: ../pages/mainPage.php?msg=ItemDeleted");
        exit();
    } else {
        echo "Error deleting item. You might not have the right permissions or the item does not exist.";
    }
} else {
    echo "Invalid request.";
}
?>
