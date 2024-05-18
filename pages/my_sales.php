<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/transactions.class.php');
require_once(__DIR__ . '/../database/users.class.php');
require_once(__DIR__ . '/../templates/common.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$soldItems = Transaction::getTransactionsBySeller($db, $user_id);

drawHeader('My Sales', true, false, $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/my_items.css">

<div class="items-container">
    <?php if (count($soldItems) > 0): ?>
        <div class="items-list">
            <?php foreach ($soldItems as $transaction): ?>
                <?php
                $item = Item::getItemById($db, $transaction->item_id);
                $buyer = Users::getUser($db, $transaction->buyer_id);
                ?>
                <div class="item">
                    <a href="item.php?id=<?= $item->id ?>">
                        <img src="<?= htmlspecialchars($item->image_path) ?>" alt="<?= htmlspecialchars($item->title) ?>">
                        <h3><?= htmlspecialchars($item->title) ?></h3>
                    </a>
                    <p>Sold to: <?= htmlspecialchars($buyer->name) ?> (<?= htmlspecialchars($buyer->email) ?>)</p>
                    <p>Transaction Date: <?= htmlspecialchars($transaction->transaction_date) ?></p>
                    <a href="print_shipping_form.php?transaction_id=<?= $transaction->transaction_id ?>" class="print-button">Print Shipping Form</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>You haven't sold any items yet.</p>
    <?php endif; ?>
</div>

<?php
drawFooter();
?>
