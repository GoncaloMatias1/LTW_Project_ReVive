<?php
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/items.class.php');

$session = new Session();
$db = getDatabaseConnection();

if (!$session->isLoggedIn()) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $itemId = intval($_POST['item_id'] ?? 0);
    $item = Item::getItemById($db, $itemId);

    if ($item && $item->user_id == $_SESSION['user_id']) {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = floatval($_POST['price'] ?? 0);
        $city = $_POST['city'] ?? '';
        $category_id = intval($_POST['category_id'] ?? 0);

        $image_path = $item->image_path;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $fileTmpName = $_FILES['image']['tmp_name'];
            $fileName = uniqid('', true) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_path = '../uploads/' . $fileName;
            move_uploaded_file($fileTmpName, $image_path);
        }

        $item->title = $title;
        $item->description = $description;
        $item->price = $price;
        $item->city = $city;
        $item->category_id = $category_id;
        $item->image_path = $image_path;

        if ($item->updateItem($db)) {
            header("Location: ../pages/item.php?id=" . $itemId);
            exit();
        } else {
            echo "Error updating item.";
        }
    } else {
        echo "Unauthorized action.";
    }
}
?>

