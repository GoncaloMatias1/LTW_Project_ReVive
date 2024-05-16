<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/wishlist.class.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$itemId = intval($_POST['item_id'] ?? 0);

if ($itemId && Wishlist::addToWishlist($db, $_SESSION['user_id'], $itemId)) {
    header("Location: wishlist.php");
    exit();
} else {
    header("Location: item.php?id=" . $itemId . "&error=unable_to_add_wishlist");
    exit();
}
?>
