<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/categories.class.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();
$db = getDatabaseConnection();

$categories = Category::getAllCategories($db);

drawHeader('Categories', true, true, $session);
?>

<div class="content-container">
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
