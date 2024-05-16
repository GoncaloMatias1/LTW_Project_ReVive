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
$userId = $session->getId();
$conversations = Message::getConversations($db, $userId);

drawHeader('Conversations', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/conversations.css">

<div class="conversations-container">
    <h1>Conversations</h1>
    <div class="conversations-list">
        <?php if (!empty($conversations)): ?>
            <?php foreach ($conversations as $conversation): ?>
                <div class="conversation">
                    <a href="message.php?item_id=<?= htmlspecialchars($conversation['item_id']) ?>&receiver_id=<?= htmlspecialchars($conversation['receiver_id']) ?>">
                        <p>Messages with <?= htmlspecialchars($conversation['username']) ?> about <?= htmlspecialchars($conversation['title']) ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-conversations">No messages found.</p>
        <?php endif; ?>
    </div>
</div>

<?php
drawFooter();
?>
