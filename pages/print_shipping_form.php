<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/transactions.class.php');
require_once(__DIR__ . '/../database/users.class.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$transaction_id = intval($_GET['transaction_id'] ?? 0);
$transaction = Transaction::getTransactionDetails($db, $transaction_id);

if ($transaction) {
    $item = Item::getItemById($db, $transaction->item_id);
    $buyer = Users::getUser($db, $transaction->buyer_id);
    $seller = Users::getUser($db, $transaction->seller_id);

    // Construct the buyer's address
    $address = "{$buyer->street}, {$buyer->door}, {$buyer->city}, {$buyer->state}, {$buyer->postalCode}";

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Shipping Form</title>
        <link rel="stylesheet" type="text/css" href="../styles/shipping_form.css">
    </head>
    <body>
        <div class="shipping-form">
            <h1>Packing Slip</h1>
            <p><strong>Order date:</strong> <?= htmlspecialchars($transaction->transaction_date) ?></p>
            <p><strong>Ship to:</strong> <?= htmlspecialchars($buyer->name) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($buyer->email) ?></p>
            <hr>
            <table>
                <tr>
                    <th>Qty</th>
                    <th>SKU</th>
                    <th>Description</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td><?= htmlspecialchars($item->id) ?></td>
                    <td><?= htmlspecialchars($item->title) ?></td>
                    <td>$<?= htmlspecialchars(number_format($item->price, 2)) ?></td>
                    <td>$<?= htmlspecialchars(number_format($item->price, 2)) ?></td>
                </tr>
            </table>
            <hr>
            <p><strong>Qty Total:</strong> 1</p>
            <p><strong>Sub Total:</strong> $<?= htmlspecialchars(number_format($item->price, 2)) ?></p>
            <p><strong>Total:</strong> $<?= htmlspecialchars(number_format($item->price, 2)) ?></p>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "Transaction not found.";
}
?>
