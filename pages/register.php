<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');

session_start();

drawHeader('Register');
?>

<div class="register-container">
    <form action="../actions/action_register.php" method="post">
        <h2>Create Account</h2>

        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="register-button">Register</button>
    </form>
</div>

<?php
drawFooter();
?>
