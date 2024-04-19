<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');

session_start();

drawHeader('Register');
?>

<!-- Inline CSS -->
<style>
body, html {
    height: 100%;
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    background-color: #ff00ff; /* Bright magenta, just for testing */
}



.register-container {
    width: 100%;
    max-width: 400px;
    margin: auto;
    padding-top: 50px;
}

form {
    background: #f7f7f7;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 20px;
    border-radius: 8px;
}

form h2 {
    text-align: center;
}

label {
    display: block;
    margin-top: 10px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 20px 0;
    display: inline-block;
    border: none;
    background: #eee;
    border-radius: 4px;
    box-sizing: border-box;
}

.register-button {
    background-color: #007aff;
    color: white;
    padding: 15px 20px;
    margin: 10px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    border-radius: 4px;
    font-size: 16px;
}

.register-button:hover {
    opacity: 0.8;
}

@media screen and (max-width: 400px) {
    .register-container {
        width: 95%;
        display: block;
        margin: auto;
    }
}
</style>

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
