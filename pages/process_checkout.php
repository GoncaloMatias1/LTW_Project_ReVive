<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/transactions.class.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$db = getDatabaseConnection();

$itemId = intval($_POST['item_id'] ?? 0);
$total = floatval($_POST['total'] ?? 0.0);
$fullname = $_POST['fullname'] ?? '';
$address = $_POST['address'] ?? '';
$paymentMethod = $_POST['paymentMethod'] ?? '';

// Marcar o item como vendido e inserir a transação
$item = Item::getItemById($db, $itemId);
if ($item) {
    // Inserir transação
    $buyer_id = $_SESSION['user_id'];
    $seller_id = $item->user_id;
    $stmt = $db->prepare('INSERT INTO transactions (item_id, buyer_id, seller_id, transaction_date) VALUES (?, ?, ?, ?)');
    $stmt->execute([$itemId, $buyer_id, $seller_id, date('Y-m-d H:i:s')]);

    // Atualizar item como vendido
    $stmt = $db->prepare('UPDATE items SET sold_date = ? WHERE item_id = ?');
    $stmt->execute([date('Y-m-d H:i:s'), $itemId]);
}

drawHeader('Order Confirmation', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/process_checkout.css">

<div class="confirmation-container">
    <h1>Order Confirmation</h1>
    <p>Thank you, <?= htmlspecialchars($fullname) ?>, for your purchase!</p>
    <p>Your order for <?= htmlspecialchars($item->title) ?> has been received and will be shipped to you <?= htmlspecialchars($address) ?>.</p>
    <p>Total paid: $<?= htmlspecialchars(number_format($total, 2)) ?> via <?= htmlspecialchars($paymentMethod) ?>.</p>
</div>

<?php
drawFooter();
?>
