<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/messages.class.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$db = getDatabaseConnection();
$sender_id = $session->getId();
$receiver_id = intval($_POST['receiver_id'] ?? 0);
$item_id = intval($_POST['item_id'] ?? 0);
$message = $_POST['message'] ?? '';

if ($receiver_id && $item_id && $message) {
    if (Message::sendMessage($db, $sender_id, $receiver_id, $item_id, $message)) {
        header('Location: message.php?item_id=' . $item_id . '&receiver_id=' . $receiver_id);
    } else {
        echo "Error sending message.";
    }
} else {
    echo "All fields are required.";
}
?>
