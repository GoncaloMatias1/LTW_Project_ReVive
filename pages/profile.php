<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: ../pages/login.php?redirect=profile");
    exit();
}

$user_id = $_SESSION['user_id'];
$user = Users::getUser($db, $user_id);

require_once(__DIR__ . '/../templates/common.php');
drawHeader('Profile', true, false);
?>

<div class="profile-container">
    <h2>Welcome, <?php echo $user->name; ?>!</h2>
    
    <div class="profile-details">
        <p><strong>Name:</strong> <?php echo $user->name; ?></p>
        <p><strong>Email:</strong> <?php echo $user->email; ?></p>
    </div>
    
</div>

<?php
require_once(__DIR__ . '/../templates/common.php');
drawFooter();
?>
