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

$itemId = intval($_GET['item_id'] ?? 0);

if ($itemId && Wishlist::removeFromWishlist($db, $_SESSION['user_id'], $itemId)) {
    header("Location: wishlist.php?success=removed");
    exit();
} else {
    header("Location: wishlist.php?error=unable_to_remove");
    exit();
}
?>
