<?php

class Item {
    public int $id;
    public int $user_id;
    public int $category_id;
    public string $title;
    public string $description;
    public string $city;
    public float $price;
    public string $image_path;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? 0;
        $this->user_id = $data['user_id'] ?? 0;
        $this->category_id = $data['category_id'] ?? 0;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->city = $data['city'] ?? '';
        $this->price = $data['price'] ?? 0.0;
        $this->image_path = $data['image_path'] ?? '';
    }

    static function getAllItems(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM Items');
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item($row);
        }
        return $items;
    }

    public static function insertItem(PDO $db, int $user_id, int $category_id, string $title, string $description, string $city, float $price, string $image_path) {
        $stmt = $db->prepare('
            INSERT INTO Items (user_id, category_id, title, description, city, price, image_path)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        return $stmt->execute([$user_id, $category_id, $title, $description, $city, $price, $image_path]);
    }

}

?>
