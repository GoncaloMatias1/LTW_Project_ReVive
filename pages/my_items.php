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
    <h1>My Listed Items</h1>
    <div class="items-list">
        <?php foreach ($items as $item): ?>
            <div class="item">
                <img src="<?= htmlspecialchars($item->image_path) ?>" alt="<?= htmlspecialchars($item->title) ?>">
                <h2><?= htmlspecialchars($item->title) ?></h2>
                <p><?= htmlspecialchars($item->description) ?></p>
                <p>Price: $<?= htmlspecialchars(number_format($item->price, 2)) ?></p>
                <a href="edit_item.php?item_id=<?= $item->id ?>" class="edit-button">Edit</a>
                <form action="../actions/action_delete_item.php" method="post" style="display:inline;">
                    <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
                    <button type="submit" class="remove-button">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
drawFooter();
?>
