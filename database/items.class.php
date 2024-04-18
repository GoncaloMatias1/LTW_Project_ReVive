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
    }

?>