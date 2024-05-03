<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

drawHeader('Login', 'login', false, $session);
?>

<main>
    <div class="login-container">
        <form action="../actions/action_login.php<?= isset($_GET['redirect']) ? '?redirect=' . htmlspecialchars($_GET['redirect']) : '' ?>" method="post">
            <h2>Login</h2>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="login-button">Login</button>
        </form>
    </div>
</main>

<?php
drawFooter();
?>
