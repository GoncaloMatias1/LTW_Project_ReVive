<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();

drawHeader('Cookie Policy', true, false, $session);
?>

<div class="content-container">
    <h2>Cookie Policy</h2>
    <p>Please read this Cookie Policy and Similar Technologies carefully before using this website or application.</p>
    
    <h3>Updated: May 2, 2024</h3>
    
    <h3>Essential Information</h3>
    <p><strong>What are Cookies?</strong></p>
    <p>Cookies are small text files that can be placed on your device (such as a computer, smartphone, or tablet) when you visit a website or use an application. These files contain information about the user's interactions with the site and are used for various purposes, including improving the user experience, tracking user behavior, and personalizing content. Cookies play a significant role in how websites function and provide a personalized browsing experience.</p>
    
    <h3>Why Do We Use Cookies?</h3>
    <p>Cookies serve several functions, such as facilitating navigation, storing your preferences to show you relevant content, and enhancing your overall user experience. We use cookies:</p>
    <ul>
        <li>To ensure the proper functioning of our services;</li>
        <li>To ensure the effectiveness of our security measures and detect fraudulent activities, including identifying your device;</li>
        <li>To technically deliver ads or content relevant to you;</li>
        <li>To manage your preferences and enhance certain functionalities in our services;</li>
        <li>To analyze how our services are accessed or used and their performance;</li>
        <li>To display ads based on the content you are viewing, the application you are using, your approximate location, or the type of your device, subject to your consent.</li>
    </ul>
    
    
    <h3>Managing Your Cookie Settings</h3>
    <p>In our services, we give you full control and the ability to refuse at any time the use of any third-party plugins or tools that connect to external service provider servers. By clicking the "View Purposes" button displayed in our cookie banner, you can access the preferences manager. There, you will find a comprehensive list of cookie modules we use, as well as details about cookies set by our advertising partners and other vendors, along with the purposes for which we use these vendors. With one click, you can enable or disable any non-essential cookies, whether set by us or by one of our partners. Cookies can be enabled/disabled as a complete category or individually.</p>
    
    
    <p>If you have any questions or concerns about our Cookie Policy, please contact us.</p>
</div>

<?php drawFooter(); ?>
