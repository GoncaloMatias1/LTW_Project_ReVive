<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');

function drawHeader($title = 'reVive : Buy and Sell', $includeTopBar = false, $includeProfileIcon = false, Session $session = null) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title; ?></title>
        <link rel="stylesheet" type="text/css" href="../styles/register.css">
        <link rel="stylesheet" type="text/css" href="../styles/mainPage.css">
        <link rel="stylesheet" type="text/css" href="../styles/login.css">
        <link rel="stylesheet" type="text/css" href="../styles/common.css">
    </head>
    <body>
        <header>
            <?php if ($includeTopBar): ?>
            <div class="top-bar">
                <div class="top-bar-left">
                    <a href="../pages/index.php">reVive</a>
                    <form action="search_page.php" method="POST">
                        <input type="text" name="search" placeholder="Search">
                        <button type="submit" name="submit-search">Search</button>
                    </form>             
                </div>
                <div class="top-bar-right">
                    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
                    <div class="menu-items">
                        <?php if ($session && $session->isLoggedIn()): ?>
                            <a href="../pages/create_item.php" class="profile-icon">Sell Item</a>
                            <a href="../pages/categories.php">Categories</a>
                            <a href="../pages/my_items.php">My Items</a>
                            <a href="../pages/wishlist.php">Wishlist</a> 
                            <?php $unreadCount = $session->getUnreadMessageCount(getDatabaseConnection()); ?>
                            <a href="../pages/conversations.php">Messages<?= $unreadCount > 0 ? " ($unreadCount)" : "" ?></a>
                            <?php if ($includeProfileIcon): ?>
                                <a href="../pages/profile.php" class="profile-icon">Profile</a>
                            <?php endif; ?>
                            <a href="../actions/action_logout.php">Logout</a>
                        <?php else: ?>
                            <a href="../pages/login.php">Login</a>
                            <a href="../pages/register.php">Create Account</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </header>
        <main>
    <?php
}

function drawFooter() {
    ?>
        </main>
        <footer>
            <div class="bottom-bar">
                <div class="bottom-bar-container">
                    <a href="../pages/about-us.php" class="bottom-bar-button">About Us</a>
                    <a href="../pages/terms.php" class="bottom-bar-button">Terms of Service</a>
                    <a href="../pages/contact.php" class="bottom-bar-button">Contact Us</a>
                    <a href="../pages/cookies.php" class="bottom-bar-button">Cookie Policy</a>
                </div>
            </div>
            <p>LTW Buy & Sell &copy; 2024</p>
        </footer>
        <script>
        function toggleMenu() {
            const menuItems = document.querySelector('.menu-items');
            if (menuItems.style.display === 'none' || menuItems.style.display === '') {
                menuItems.style.display = 'flex';
            } else {
                menuItems.style.display = 'none';
            }
        }
        </script>
    </body>
    </html>
    <?php
}
?>
