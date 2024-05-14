<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

    $fie = $_FILES['image'];

    $filename = $_FILES['image']['name'];
    $filetmpname = $_FILES['image']['tmp_name'];
    $filesize = $_FILES['image']['size'];
    $fileerror = $_FILES['image']['error'];
    $filetyoe = $_FILES['image']['type'];

    $fileExt = explode('.', $filename);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if(in_array($fileActualExt, $allowed)){
        if($fileerror === 0){
            if($filesize < 1000000){
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = '../uploads/'.$fileNameNew;
                move_uploaded_file($filetmpname, $fileDestination);
                $image_path = $fileDestination;
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }


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
