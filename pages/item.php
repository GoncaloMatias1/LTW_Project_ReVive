<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/users.class.php');
require_once(__DIR__ . '/../database/reviews.class.php');

$session = new Session();
$db = getDatabaseConnection();
if ($session->isLoggedIn()) {
    $user_id = $_SESSION['user_id'];
    $user = Users::getUser($db, $user_id);
}

$itemId = intval($_GET['id'] ?? 0);
$item = Item::getItemById($db, $itemId);

$seller = $item ? Users::getUser($db, $item->user_id) : null;

drawHeader('Item Details', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/itemDetail.css">

<div class="item-detail">
    <?php if ($item): ?>
        <div class="item-info">
            <img src="<?= htmlspecialchars($item->image_path) ?>" alt="<?= htmlspecialchars($item->title) ?>">
            <div class="item-details">
                <h1><?= htmlspecialchars($item->title) ?></h1>
                <p><?= htmlspecialchars($item->description) ?></p>
                <p>Located in: <?= htmlspecialchars($item->city ?? 'Not specified') ?></p>
                <p>Price: $<?= htmlspecialchars(number_format($item->price, 2)) ?></p>
                <div class="buttons">
                    <?php if ($session->isLoggedIn()): ?>
                        <?php if ($item->user_id != $_SESSION['user_id']): ?>
                            <form action="../pages/add_to_wishlist.php" method="post">
                                <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                                <button type="submit">Add to Wishlist</button>
                            </form>
                            <form action="message.php" method="get">
                                <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                                <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($item->user_id) ?>">
                                <button type="submit">Contact Seller</button>
                            </form>
                        <?php endif; ?>
                        <?php if ($item->user_id == $_SESSION['user_id'] || $user->is_admin): ?>
                            <form action="../pages/edit_item.php" method="get">
                                <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                                <button type="submit" class="edit-button">Edit Item</button>
                            </form>
                            <form action="../actions/action_delete_item.php" method="post">
                                <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($item->user_id) ?>">
                                <button type="submit" class="delete-button">Delete Item</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($session->isLoggedIn() && $item->user_id != $_SESSION['user_id']): ?>
            <div class="reviews-checkout">
                <div class="reviews">
                    <h2>Submit a Review</h2>
                    <form action="submit_review.php" method="post">
                        <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                        <label for="rating">Rating (1-5):</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" required>
                        <label for="comment">Comment:</label>
                        <textarea id="comment" name="comment" required></textarea>
                        <button type="submit">Submit Review</button>
                    </form>
                </div>
                <div class="checkout">
                    <h2>Proceed to Checkout</h2>
                    <form action="checkout.php" method="post">
                        <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                        <button type="submit">Proceed to Checkout</button>
                    </form>
                    <div class="seller-info">
                        <h3>Seller Information</h3>
                        <?php if ($seller): ?>
                            <p>Name: <a href="user_profile.php?user_id=<?= htmlspecialchars($seller->id) ?>"><?= htmlspecialchars($seller->name) ?></a></p>
                            <p>Username: <?= htmlspecialchars($seller->username) ?></p>
                        <?php else: ?>
                            <p>Seller information not available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Item not found.</p>
    <?php endif; ?>
</div>

<?php
drawFooter();
?>
