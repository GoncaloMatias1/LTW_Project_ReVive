<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();
drawHeader('About Us', true, false, $session);
?>

<div class="content-container">
    <h2>About Us</h2>
    <p>Welcome to reVive!</p>
    <p>We are a new company in the online marketplace industry, dedicated to providing a platform for buying and selling pre-loved items. Our site is made by four students from FEUP: Gonçalo Matias, Gonçalo Barroso, and Pedro Plácido.</p>
    <p>Our team is passionate about creating a seamless experience for users to easily list, browse, and transact with pre-loved items. Please note that our site is still under development, and we are continuously working to improve and enhance the platform.</p>
</div>

<?php drawFooter(); ?>
