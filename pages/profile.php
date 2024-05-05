<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');
require_once(__DIR__ . '/../templates/common.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user = Users::getUser($db, $user_id);

drawHeader('Profile', true, false, $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/profile.css">

<div class="profile-container">
    <h2>Welcome, <?php echo htmlspecialchars($user->name); ?>!</h2>
    <div class="profile-details">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user->name); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
        <a href="edit_profile.php">Edit Profile</a>
    </div>
</div>

<?php
drawFooter();
?>
