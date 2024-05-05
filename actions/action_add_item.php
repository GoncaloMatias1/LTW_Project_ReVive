<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');
require_once(__DIR__ . '/../database/users.class.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = floatval($_POST['price'] ?? 0);
    $city = $_POST['city'] ?? '';
    $category_id = intval($_POST['category_id'] ?? 0);
    $image_path = '';

    if ($title && $description && $price > 0 && $city && $category_id) {
        $item = new Item([
            'user_id' => $_SESSION['user_id'],
            'category_id' => $category_id,
            'title' => $title,
            'description' => $description,
            'city' => $city,
            'price' => $price,
            'image_path' => $image_path
        ]);
        
        if ($item->addItem($db)) {
            header("Location: ../pages/item.php?id=" . $db->lastInsertId());
            exit();
        } else {
            echo "Error adding item.";
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>
