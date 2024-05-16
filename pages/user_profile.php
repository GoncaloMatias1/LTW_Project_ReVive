<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');
require_once(__DIR__ . '/../database/reviews.class.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../templates/common.php');

$session = new Session();
$db = getDatabaseConnection();

$user_id = intval($_GET['user_id']);
$user = Users::getUser($db, $user_id);
$reviews = Reviews::getReviewsByUser($db, $user_id);
$soldItems = Item::getItemsByUser($db, $user_id);  // assuming items marked as sold

$loggedUser_id = $_SESSION['user_id'];
$loggedUser = Users::getUser($db, $loggedUser_id);

drawHeader($user->username . "'s Profile", true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/profile.css">

<div class="profile-container">
    <h2>Profile of <?php echo htmlspecialchars($user->username); ?></h2>
    <div class="profile-details">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user->name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
    </div>
    <?php if ($loggedUser->is_admin && !$user->is_admin && $user_id != $loggedUser_id): ?>
        <form action="../actions/action_make_admin.php" method="POST">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
            <button type="submit">Make Admin</button>
    <?php endif; ?>
    <?php if ($loggedUser->is_admin && $user->is_admin && $user_id != $loggedUser_id): ?>
        <form action="../actions/action_remove_admin.php" method="POST">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">
            <button type="submit">Remove Admin</button>
    <?php endif; ?>
    
    <h3>Reviews</h3>
    <div class="user-reviews">
        <?php if (count($reviews) > 0): ?>
            <ul>
                <?php foreach ($reviews as $review): ?>
                    <li>
                        <p><strong>Rating:</strong> <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                        <p><strong>Comment:</strong> <?php echo htmlspecialchars($review['comment']); ?></p>
                        <p><strong>Date:</strong> <?php echo htmlspecialchars($review['review_date']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div>

    <h3>Sold Items</h3>
    <div class="sold-items">
        <?php if (count($soldItems) > 0): ?>
            <ul>
                <?php foreach ($soldItems as $item): ?>
                    <li>
                        <p><strong>Title:</strong> <?php echo htmlspecialchars($item->title); ?></p>
                        <p><strong>Price:</strong> $<?php echo htmlspecialchars(number_format($item->price, 2)); ?></p>
                        <p><strong>Sold on:</strong> <?php echo htmlspecialchars($item->sold_date ?? 'N/A'); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No items sold yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php
drawFooter();
?>
