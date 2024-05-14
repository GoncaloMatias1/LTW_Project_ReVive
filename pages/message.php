<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/messages.class.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$db = getDatabaseConnection();
$itemId = intval($_GET['item_id'] ?? 0);
$receiverId = intval($_GET['receiver_id'] ?? 0);

$senderId = $session->getId();
$messages = Message::getMessages($db, $senderId, $itemId);

drawHeader('Messages', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/messages.css">

<div class="messages-container">
    <h1>Messages</h1>
    <div class="message-list">
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $message): ?>
                <div class="message">
                    <p><strong><?= htmlspecialchars($message['sender_id']) == $session->getId() ? 'You' : 'Seller' ?>:</strong> <?= htmlspecialchars($message['message']) ?></p>
                    <span class="timestamp"><?= htmlspecialchars($message['timestamp']) ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>
    </div>
    <form action="send_message.php" method="post">
        <input type="hidden" name="item_id" value="<?= htmlspecialchars($itemId) ?>">
        <input type="hidden" name="receiver_id" value="<?= htmlspecialchars($receiverId) ?>">
        <textarea name="message" required placeholder="Write your message here..."></textarea>
        <button type="submit">Send</button>
    </form>
</div>

<?php
drawFooter();
?>
