<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

$error = isset($_GET['error']) ? $_GET['error'] : '';

drawHeader('Register', 'register', false, $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/register.css">

<div class="register-container">
    <form id="register-form" action="../actions/action_register.php" method="post" onsubmit="return validateForm()">
        <h2>Create Account</h2>

        <?php if ($error): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="register-button">Register</button>
    </form>
</div>

<script>
function validateForm() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    if (password !== confirm_password) {
        alert("Passwords do not match.");
        return false;
    }
    return true;
}
</script>

<?php
drawFooter();
?>
