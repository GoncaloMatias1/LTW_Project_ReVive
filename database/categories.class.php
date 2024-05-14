<?php

declare(strict_types = 1);

class Category {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;    
    }

    public static function getAllCategories(PDO $db): array {
        $stmt = $db->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addCategory(PDO $db, string $category_name): bool {
        $stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
        return $stmt->execute([$category_name]);
    }
}
?>
