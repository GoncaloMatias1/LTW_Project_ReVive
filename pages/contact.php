<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

drawHeader('Contact Us', true, false, $session);
?>

<div class="content-container">
    <h2>Contact Us</h2>
    <p>Have a question, suggestion, or feedback for us? We'd love to hear from you!</p>
    <p>You can reach out to us via email at <a href="mailto:up202108703@up.pt">up202108703@up.pt</a>.</p>
    <p>Our dedicated team is committed to providing you with excellent service and support. Whether you're experiencing an issue with our platform or simply want to share your thoughts with us, we're here to help.</p>
    <p>We strive to respond to all inquiries in a timely manner. Your feedback is valuable to us as we continue to improve and enhance the reVive experience for our users.</p>
</div>

<?php drawFooter(); ?>
