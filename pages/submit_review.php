<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/reviews.class.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$itemId = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if ($itemId > 0 && $rating >= 1 && $rating <= 5 && !empty($comment)) {
    $success = Reviews::addReview($db, $_SESSION['user_id'], $itemId, $rating, $comment);

    if ($success) {
        header("Location: item.php?id=$itemId&review_success=1");
    } else {
        header("Location: item.php?id=$itemId&review_error=1");
    }
} else {
    header("Location: item.php?id=$itemId&review_error=1");
}
exit();
