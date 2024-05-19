<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/wishlist.class.php');
require_once(__DIR__ . '/../templates/common.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$wishlistItems = Wishlist::getUserWishlist($db, $_SESSION['user_id']);

drawHeader('Your Wishlist', true, true, $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/wishlist.css">

<div class="wishlist-container">
    <?php if (count($wishlistItems) > 0): ?>
        <div class="wishlist-items">
            <?php foreach ($wishlistItems as $item): ?>
                <div class="wishlist-item">
                    <a href="item.php?id=<?= $item['item_id'] ?>">
                        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                        <h3><?= htmlspecialchars($item['title']) ?></h3>
                        <p class="price">Price: $<?= htmlspecialchars(number_format($item['price'], 2)) ?></p>
                    </a>
                    <a href="remove_from_wishlist.php?item_id=<?= $item['item_id'] ?>" class="remove-button">Remove</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No items in your wishlist yet.</p>
    <?php endif; ?>
</div>

<?php
drawFooter();
?>
