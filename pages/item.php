<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/reviews.class.php');

$session = new Session();
$db = getDatabaseConnection();
$itemId = intval($_GET['id'] ?? 0);
$item = Item::getItemById($db, $itemId);

drawHeader('Item Details', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/itemDetail.css">

<div class="item-detail">
    <?php if ($item): ?>
        <img src="<?= htmlspecialchars($item->image_path) ?>" alt="<?= htmlspecialchars($item->title) ?>">
        <h1><?= htmlspecialchars($item->title) ?></h1>
        <p><?= htmlspecialchars($item->description) ?></p>
        <p>Brand: <?= htmlspecialchars($item->brand) ?>, Model: <?= htmlspecialchars($item->model) ?></p>
        <p>Size: <?= htmlspecialchars($item->size ?? 'Not specified') ?></p>
        <p>Condition: <?= htmlspecialchars($item->condition) ?></p>
        <p>Located in: <?= htmlspecialchars($item->city) ?></p>
        <p>Price: $<?= htmlspecialchars(number_format($item->price, 2)) ?></p>
        
        <?php if ($session->isLoggedIn()): ?>
            <form action="submit_review.php" method="post">
                <input type="hidden" name="item_id" value="<?= $item->id ?>">
                <label for="rating">Rating (1-5):</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" required></textarea>
                <button type="submit">Submit Review</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <p>Item not found.</p>
    <?php endif; ?>
</div>

<?php
drawFooter();
?>
