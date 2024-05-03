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
        $this->id = $data['item_id'] ?? 0;
        $this->user_id = $data['user_id'] ?? 0;
        $this->category_id = $data['category_id'] ?? 0;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->brand = $data['brand'] ?? null; 
        $this->model = $data['model'] ?? null;
        $this->size = $data['size'] ?? null;
        $this->condition = $data['condition'] ?? null; 
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
    

    static function getItemById(PDO $db, int $id): ?Item {
        $stmt = $db->prepare('SELECT * FROM Items WHERE item_id = ?');
        if (!$stmt) {
            die("Prepare failed: " . $db->errorInfo()[2]);
        }
        $stmt->execute([$id]);
        if (!$stmt) {
            die("Execute failed: " . $db->errorInfo()[2]);
        }
        $item = $stmt->fetch();
        return $item ? new Item($item) : null;
    }
    
}

?>
