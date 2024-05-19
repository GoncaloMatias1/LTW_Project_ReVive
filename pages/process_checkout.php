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
$street = $_POST['street'] ?? '';
$door = $_POST['door'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$postalCode = $_POST['postalCode'] ?? '';
$paymentMethod = $_POST['paymentMethod'] ?? '';

$address = "$street, $door, $city, $state, $postalCode";

$item = Item::getItemById($db, $itemId);
if ($item) {
    $buyer_id = $_SESSION['user_id'];
    $stmt = $db->prepare('UPDATE users SET street = ?, door = ?, city = ?, state = ?, postalCode = ? WHERE user_id = ?');
    $stmt->execute([$street, $door, $city, $state, $postalCode, $buyer_id]);

    $seller_id = $item->user_id;
    $stmt = $db->prepare('INSERT INTO transactions (item_id, buyer_id, seller_id, transaction_date) VALUES (?, ?, ?, ?)');
    $stmt->execute([$itemId, $buyer_id, $seller_id, date('Y-m-d H:i:s')]);

    $stmt = $db->prepare('UPDATE items SET sold_date = ? WHERE item_id = ?');
    $stmt->execute([date('Y-m-d H:i:s'), $itemId]);
}

drawHeader('Order Confirmation', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/process_checkout.css">

<div class="confirmation-container">
    <h1>Order Confirmation</h1>
    <p>Thank you, <?= htmlspecialchars($fullname) ?>, for your purchase!</p>
    <p>Your order for <?= htmlspecialchars($item->title) ?> has been received and will be shipped to <?= htmlspecialchars($address) ?>.</p>
    <p>Total paid: $<?= htmlspecialchars(number_format($total, 2)) ?> via <?= htmlspecialchars($paymentMethod) ?>.</p>
</div>

<?php
drawFooter();
?>
