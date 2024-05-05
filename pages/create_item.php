<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/categories.class.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$categories = Category::getAllCategories($db);

drawHeader('Add Item', true, true, $session);
?>

<div class="add_item_container">
    <form action="../actions/action_add_item.php" method="post" enctype="multipart/form-data">
        <h2>Add New Item</h2>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Price ($):</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>

        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image">

        <button type="submit">Add Item</button>
    </form>
</div>

<?php drawFooter(); ?>
