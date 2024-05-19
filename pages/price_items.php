<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();
$db = getDatabaseConnection();

$price_range = $_GET['price_range'] ?? '';
$price_ranges = [
    'below_10' => [0, 10],
    '10_20' => [10, 20],
    '20_30' => [20, 30],
    '30_40' => [30, 40],
    '40_50' => [40, 50],
    '50_100' => [50, 100],
    '100_500' => [100, 500],
    'above_500' => [500, null]
];

if (isset($price_ranges[$price_range])) {
    [$minPrice, $maxPrice] = $price_ranges[$price_range];
    $items = Item::getItemsByPriceRange($db, $minPrice, $maxPrice);
} else {
    $items = [];
}

drawHeader('Items by Price', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/category_items.css">

<div class="items-container">
    <?php
    if (empty($items)) {
        echo "<p>No items found for this price range.</p>";
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
    ?>
</div>

<?php
drawFooter();
?>
