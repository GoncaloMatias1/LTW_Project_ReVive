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

$itemId = intval($_GET['item_id'] ?? 0);
$item = Item::getItemById($db, $itemId);

if (!$item || $item->user_id != $_SESSION['user_id']) {
    header("Location: my_items.php");
    exit();
}

$categories = Category::getAllCategories($db);

drawHeader('Edit Item', true, true, $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/add_item.css">

<div class="add_item_container">
    <form action="../actions/action_edit_item.php" method="post" enctype="multipart/form-data">
        <h2>Edit Item</h2>

        <input type="hidden" name="item_id" value="<?= htmlspecialchars($item->id) ?>">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($item->title) ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($item->description) ?></textarea>

        <label for="price">Price ($):</label>
        <input type="number" id="price" name="price" value="<?= htmlspecialchars($item->price) ?>" step="0.01" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?= htmlspecialchars($item->city) ?>" required>

        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $item->category_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image">

        <button type="submit">Update Item</button>
    </form>
</div>

<?php drawFooter(); ?>
