<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$db = getDatabaseConnection();
$itemId = intval($_POST['item_id'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);
$item = Item::getItemById($db, $itemId);

drawHeader('Checkout', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/checkout.css">

<div class="checkout-container">
    <h1>Checkout</h1>
    <?php if ($item): ?>
        <p><?= htmlspecialchars($item->title) ?> - $<?= htmlspecialchars(number_format($item->price, 2)) ?></p>
        <p>Quantity: <?= $quantity ?></p>
        <p>Total: $<?= htmlspecialchars(number_format($item->price * $quantity, 2)) ?></p>
        <form action="process_checkout.php" method="post">
            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">
            <input type="hidden" name="total" value="<?= htmlspecialchars($item->price * $quantity) ?>">

            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required>

            <fieldset>
                <legend>Address Details</legend>
                <div class="form-row">
                    <div class="form-group">
                        <label for="street">Street:</label>
                        <input type="text" id="street" name="street" required>
                    </div>
                    <div class="form-group">
                        <label for="door">Door Number:</label>
                        <input type="text" id="door" name="door" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="state">State/Province/Region:</label>
                        <input type="text" id="state" name="state" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="postalCode">Postal Code:</label>
                        <input type="text" id="postalCode" name="postalCode" required>
                    </div>
                </div>
            </fieldset>

            <label for="paymentMethod">Payment Method:</label>
            <select id="paymentMethod" name="paymentMethod">
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="debit_card">Debit Card</option>
            </select>

            <button type="submit">Confirm Purchase</button>
        </form>
    <?php else: ?>
        <p>Item not found.</p>
    <?php endif; ?>
</div>

<?php
drawFooter();
?>
