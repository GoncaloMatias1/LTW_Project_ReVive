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

drawHeader('Your Favorites', true, true, $session);
?>


<div class="wishlist-container">
    <?php if (count($wishlistItems) > 0): ?>
        <ul>
            <?php foreach ($wishlistItems as $item): ?>
                <li>
                    <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                    <h3><?= htmlspecialchars($item['title']) ?></h3>
                    <p><?= htmlspecialchars($item['description']) ?></p>
                    <a href="remove_from_wishlist.php?item_id=<?= $item['item_id'] ?>">Remove</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You haven't added any favorites yet.</p>
    <?php endif; ?>
</div>

<?php
drawFooter();
?>
