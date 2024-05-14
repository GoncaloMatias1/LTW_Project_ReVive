<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../templates/common.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$items = Item::getItemsByUser($db, $user_id);

drawHeader('My Items', true, false, $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/my_items.css">

<div class="items-container">
    <?php if (count($items) > 0): ?>
        <div class="items-list">
            <?php foreach ($items as $item): ?>
                <div class="item">
                    <a href="item.php?id=<?= $item->id ?>">
                        <img src="<?= htmlspecialchars($item->image_path) ?>" alt="<?= htmlspecialchars($item->title) ?>">
                        <h3><?= htmlspecialchars($item->title) ?></h3>
                    </a>
                    <div class="buttons">
                        <a href="edit_item.php?item_id=<?= $item->id ?>" class="edit-button">Edit</a>
                        <form action="../actions/action_delete_item.php" method="post" class="delete-form">
                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>You haven't listed any items yet.</p>
    <?php endif; ?>
</div>

<?php
drawFooter();
?>
