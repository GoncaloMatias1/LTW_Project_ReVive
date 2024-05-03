<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();
$db = getDatabaseConnection();

$items = Item::getAllItems($db);

drawHeader('Main Page', true, true);
?>

<div class="content-container">
    <h2>Featured Items</h2>
    <div class="items-list">
        <?php foreach ($items as $item): ?>
            <div class="item">
                <a href="item.php?id=<?= $item->id ?>">
                    <img src="<?= htmlspecialchars($item->image_path) ?>" alt="Item Image">
                    <h3><?= htmlspecialchars($item->title) ?></h3>
                    <p><?= htmlspecialchars($item->description) ?></p>
                    <span>Price: $<?= htmlspecialchars(number_format($item->price, 2)) ?></span>
                    <button>Take a look!</button>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php drawFooter(); ?>
