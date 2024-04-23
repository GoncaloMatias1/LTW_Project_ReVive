<?php
require_once(__DIR__ . '/../templates/common.php');
require_once(__DIR__ . '/../utils/session.php');

drawHeader('Main Page');
?>

<div class="content-container">
    <h2>Featured Items</h2>
    <div class="items-list">
        <div class="item">
            <img src="path_to_image" alt="Item Image">
            <h3>Item Name</h3>
            <p>Description of the item...</p>
            <span>Price: $xx.xx</span>
            <button>Buy Now</button>
        </div>
    </div>
</div>

<?php
drawFooter();
?>
