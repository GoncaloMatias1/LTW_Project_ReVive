<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();
$db = getDatabaseConnection();

$category_id = filter_var($_GET['category_id'] ?? 0, FILTER_VALIDATE_INT);

if ($category_id > 0) {
    $items = Item::getItemsByCategory($db, $category_id);
    if (empty($items)) {
        echo "No items found for this category.";
    } else {
        drawHeader('Category Items', true, $session->isLoggedIn(), $session);
        echo "<div class='items-container'>";
        foreach ($items as $item) {
            echo "<div class='item'><h3>" . htmlspecialchars($item->title) . "</h3></div>";
        }
        echo "</div>";
        drawFooter();
    }
} else {
    echo "Invalid category ID.";
    drawFooter();
}
