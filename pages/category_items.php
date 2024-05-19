<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();
$db = getDatabaseConnection();

$category_id = filter_var($_GET['category_id'] ?? 0, FILTER_VALIDATE_INT);

drawHeader('Category Items', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/category_items.css">

<div class="items-container">
    <?php
    if ($category_id > 0) {
        $items = Item::getItemsByCategory($db, $category_id);
        if (empty($items)) {
            echo "<p>No items found for this category.</p>";
        } else {
            echo "<div class='items-list'>";
            foreach ($items as $item) {
                echo "<div class='item'>
                        <a href='item.php?id=" . htmlspecialchars($item->id) . "'>
                            <img src='" . htmlspecialchars($item->image_path) . "' alt='" . htmlspecialchars($item->title) . "'>
                            <h3>" . htmlspecialchars($item->title) . "</h3>
                            <p class='price'>Price: $" . htmlspecialchars(number_format($item->price, 2)) . "</p>
                        </a>
                    </div>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>Invalid category ID.</p>";
    }
    ?>
</div>

<?php
drawFooter();
?>
