<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

$session = new Session();
$db = getDatabaseConnection();

drawHeader('Price Filter', true, $session->isLoggedIn(), $session);
?>

<link rel="stylesheet" type="text/css" href="../styles/categories.css">

<div class="content-container">
    <h2>Browse by Price</h2>
    <div class="categories-list">
        <div class="category">
            <a href="price_items.php?price_range=below_10">
                <h3>Below $10</h3>
            </a>
        </div>
        <div class="category">
            <a href="price_items.php?price_range=10_20">
                <h3>$10 - $20</h3>
            </a>
        </div>
        <div class="category">
            <a href="price_items.php?price_range=20_30">
                <h3>$20 - $30</h3>
            </a>
        </div>
        <div class="category">
            <a href="price_items.php?price_range=30_40">
                <h3>$30 - $40</h3>
            </a>
        </div>
        <div class="category">
            <a href="price_items.php?price_range=40_50">
                <h3>$40 - $50</h3>
            </a>
        </div>
        <div class="category">
            <a href="price_items.php?price_range=50_100">
                <h3>$50 - $100</h3>
            </a>
        </div>
        <div class="category">
            <a href="price_items.php?price_range=100_500">
                <h3>$100 - $500</h3>
            </a>
        </div>
        <div class="category">
            <a href="price_items.php?price_range=above_500">
                <h3>Above $500</h3>
            </a>
        </div>
    </div>
</div>

<?php drawFooter(); ?>
