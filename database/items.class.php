<?php

    declare(strict_types = 1);

    class Item {
        public int $id;
        public int $user_id;
        public int $category_id;
        public string $title;
        public string $descriptiom;
        public string $brand;
        public string $model;
        public string $size;
        public string $condition;
        public string $city;
        public float $price;
        public float $image_path;

//        static function insertItem(PDO $db, ): bool{
//            $stmt = $db->prepare('
//                INSERT INTO Items (user_id, category_id, title, description, brand, model, size, condition, city, price, image_path)
//                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
//            ');
//
//            return $stmt->execute([$name, $username, $email, $hashed_password, $is_admin]);
//        }
    }

?>