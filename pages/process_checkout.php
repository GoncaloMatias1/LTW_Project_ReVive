<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

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

drawHeader('Order Confirmation', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/process_checkout.css">

<div class="confirmation-container">
    <h1>Order Confirmation</h1>
    <p>Thank you, <?= htmlspecialchars($fullname) ?>, for your purchase!</p>
    <p>Your order for <?= htmlspecialchars($itemId) ?> has been received and will be shipped to you<?= htmlspecialchars($address) ?>.</p>
    <p>Total paid: $<?= htmlspecialchars(number_format($total, 2)) ?> via <?= htmlspecialchars($paymentMethod) ?>.</p>
</div>

<?php
drawFooter();
?>
