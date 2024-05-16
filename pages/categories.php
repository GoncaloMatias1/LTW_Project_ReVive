<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/categories.class.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/users.class.php');

$session = new Session();

$db = getDatabaseConnection();

$user_id = $_SESSION['user_id'];
$user = Users::getUser($db, $user_id);

$categories = Category::getAllCategories($db);

drawHeader('Categories', true, true, $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/categories.css">

<div class="content-container">
    <?php if ($user->is_admin): ?>
        <form action="../actions/action_add_category.php" method="POST">
            <input type="text" name="category_name" placeholder="Enter new category name">
            <button type="submit" class="add-category-button">Add Category</button>
        </form>
    <?php endif; ?>
    <h2>Browse by Categories</h2>
    <div class="categories-list">
        <?php foreach ($categories as $category): ?>
            <div class="category">
                <a href="category_items.php?category_id=<?= $category['category_id']; ?>">
                    <h3><?= htmlspecialchars($category['name']) ?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php drawFooter(); ?>
