<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');
require_once(__DIR__ . '/../database/reviews.class.php');
require_once(__DIR__ . '/../templates/common.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = Users::getUser($db, $user_id);
$reviews = Reviews::getReviewsByUser($db, $user_id);

drawHeader('Profile', true, true, $session); 
?>

<link rel="stylesheet" type="text/css" href="../styles/profile.css">

<div class="profile-container">
    <h2>Welcome, <?php echo htmlspecialchars($user->name); ?>!</h2>
    <div class="profile-details">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user->name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
        <a href="edit_profile.php">Edit Profile</a>
    </div>
    
    <h3>Reviews for Your Items</h3>
    <div class="user-reviews">
        <?php if (count($reviews) > 0): ?>
            <ul>
                <?php foreach ($reviews as $review): ?>
                    <li>
                        <p><strong>Product:</strong> <?php echo htmlspecialchars($review['title']); ?></p>
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
</div>

<?php
drawFooter();
?>
