<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();

$db = getDatabaseConnection();
$itemId = intval($_GET['id'] ?? 0);
$item = Item::getItemById($db, $itemId);

drawHeader('Item Details', true, false, $session);
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
        <button>Add to Wishlist</button>
    <?php else: ?>
        <p>Item not found.</p>
    <?php endif; ?>
</div>

<?php
drawFooter();
?>
