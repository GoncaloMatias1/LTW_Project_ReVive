<?php

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

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? 0;
        $this->user_id = $data['user_id'] ?? 0;
        $this->category_id = $data['category_id'] ?? 0;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->brand = $data['brand'] ?? '';
        $this->model = $data['model'] ?? '';
        $this->size = $data['size'] ?? null;
        $this->condition = $data['condition'] ?? '';
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
    
}

?>
