<?php
    require_once(__DIR__ . '/../templates/common.php');
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/items.class.php');
    
    $session = new Session();
    $db = getDatabaseConnection();

    drawHeader('Add Item', true);
?>
    <div class="add_item_container">
    <form action="../actions/action_add_item.php" method="post">
        <h2>Add New Item</h2>

        <label for="title">Item Name</label>
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

<?php drawFooter(); ?>