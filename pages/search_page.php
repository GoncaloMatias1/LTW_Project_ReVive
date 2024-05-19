<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();
$db = getDatabaseConnection();

drawHeader('Searched Items', true, $session->isLoggedIn(), $session);

?>

<link rel="stylesheet" type="text/css" href="../styles/search_page.css">

<div class="items-container">
    <?php
        if (isset($_POST['submit-search'])) {
            $items = Item::getItemsBySearch($db, $_POST['search']);
            if (!empty($items)) {
                echo "<div class='items-list'>";
                foreach ($items as $item) {
                    echo "<div class='item'>
                            <a href='item.php?id=" . htmlspecialchars($item->id) . "'>
                                <img src='" . htmlspecialchars($item->image_path) . "' alt='" . htmlspecialchars($item->title) . "'>
                                <h3>" . htmlspecialchars($item->title) . "</h3>
                                <p>Price: $" . htmlspecialchars(number_format($item->price, 2)) . "</p>
                            </a>
                        </div>";
                }
                echo "</div>";
            } else {
                echo "<p>There are no results matching your search!</p>";
            }
        }
    ?>
</div>

<?php
drawFooter();
?>
