<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/users.class.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user = Users::getUser($db, $user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? $user->name;
    $email = $_POST['email'] ?? $user->email;


    if (Users::updateUser($db, $user_id, $name, $email)) {
        header("Location: profile.php");
        exit;
    } else {
        $error = "Failed to update profile.";
    }
}

require_once(__DIR__ . '/../templates/common.php');
drawHeader('Edit Profile', true, false, $session);
?>

<div class="profile-container">
    <h1>Edit Profile</h1>
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form action="edit_profile.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user->name) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" required>

        <button type="submit">Update Profile</button>
    </form>
</div>

<?php
drawFooter();
?>
