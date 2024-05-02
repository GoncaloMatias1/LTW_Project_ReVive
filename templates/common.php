<?php
function drawHeader($title = 'reVive : Buy and Sell', $includeTopBar = false, $includeProfileIcon = false) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="/styles/register.css">
        <link rel="stylesheet" type="text/css" href="/styles/mainPage.css">
        <link rel="stylesheet" type="text/css" href="/styles/login.css">
        <style>
            .top-bar, .bottom-bar {
                background-color: #007aff;
                color: white;
                display: flex;
                justify-content: space-between;
                padding: 25px 35px;
                align-items: center;
            }
    
            .top-bar a, .bottom-bar-button {
                color: white;
                text-decoration: none;
                margin: 0 10px;
                font-size: 16px;
                transition: opacity 0.3s;
            }
    
            .top-bar a:hover, .bottom-bar-button:hover {
                opacity: 0.8;
            }
            
            .profile-icon {
                margin-right: 10px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <header>
            <?php if ($includeTopBar): ?>
            <div class="top-bar">
                <div class="top-bar-left">
                    <a href="../pages/index.php">reVive</a>
                </div>
                <div class="top-bar-right">
                    <?php if ($includeProfileIcon): ?>
                    <a href="../pages/profile.php" class="profile-icon">Profile</a>
                    <?php endif; ?>
                    <a href="../pages/login.php">Login</a>
                    <a href="../pages/register.php">Create Account</a>
                </div>
            </div>
            <?php endif; ?>
        </header>
        <main>
    <?php }
    
    function drawBottomBar() { ?>
        <div class="bottom-bar">
            <div class="bottom-bar-container">
                <a href="/pages/about-us.php" class="bottom-bar-button">About Us</a>
                <a href="/pages/terms.php" class="bottom-bar-button">Terms of Service</a>
                <a href="/pages/contact.php" class="bottom-bar-button">Contact Us</a>
                <a href="/pages/cookies.php" class="bottom-bar-button">Cookie Policy</a>
            </div>
        </div>
    <?php }
    
    function drawFooter() { ?>
        <?php drawBottomBar(); ?>
        <footer>
            LTW Buy & Sell &copy; 2024
        </footer>
        </main>
    </body>
    </html>
    <?php }
?>
