<?php

declare(strict_types = 1);

class Item {
    public int $id;
    public int $user_id;
    public int $category_id;
    public string $title;
    public string $description;
    public string $brand;
    public string $model;
    public ?string $size; 
    public string $condition;
    public string $city;
    public float $price;
    public string $image_path;

    static function getAllItems(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM Items');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Item');
    }
}

?>
