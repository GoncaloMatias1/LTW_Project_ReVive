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
    public ?string $sold_date;

    public function __construct(array $data = []) {
        $this->id = $data['item_id'] ?? 0;
        $this->user_id = $data['user_id'] ?? 0;
        $this->category_id = $data['category_id'] ?? 0;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->city = $data['city'] ?? '';
        $this->price = isset($data['price']) ? (float)$data['price'] : 0.0;
        $this->image_path = $data['image_path'] ?? '';
        $this->sold_date = $data['sold_date'] ?? null;
    }

    static function getAllItems(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM items WHERE sold_date IS NULL');
        $stmt->execute();
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item($row);
        }
        return $items;
    }

    static function getItemById(PDO $db, int $id): ?Item {
        $stmt = $db->prepare('SELECT * FROM items WHERE item_id = ?');
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        return $item ? new Item($item) : null;
    }

    public function addItem(PDO $db): bool {
        $stmt = $db->prepare("INSERT INTO items (user_id, category_id, title, description, city, price, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->user_id,
            $this->category_id,
            $this->title,
            $this->description,
            $this->city,
            $this->price,
            $this->image_path
        ]);
    }

    public static function deleteItem(PDO $db, int $itemId, int $userId): bool {
        $stmt = $db->prepare("DELETE FROM items WHERE item_id = ? AND user_id = ?");
        return $stmt->execute([$itemId, $userId]);
    }

    public static function getItemsByCategory(PDO $db, int $category_id): array {
        $stmt = $db->prepare("SELECT * FROM items WHERE category_id = ? AND sold_date IS NULL");
        $stmt->execute([$category_id]);
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item($row);
        }
        return $items;
    }

    public static function getItemsByUser(PDO $db, int $user_id): array {
        $stmt = $db->prepare('SELECT * FROM items WHERE user_id = ?');
        $stmt->execute([$user_id]);
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item($row);
        }
        return $items;
    }

    public static function getItemsBySearch(PDO $db, string $search): array {
        $stmt = $db->prepare("SELECT * FROM items WHERE (title LIKE ? OR description LIKE ?) AND sold_date IS NULL");
        $stmt->execute(["%$search%", "%$search%"]);
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item($row);
        }
        return $items;
    }

    public function updateItem(PDO $db): bool {
        $stmt = $db->prepare("
            UPDATE items SET title = ?, description = ?, price = ?, city = ?, category_id = ?, image_path = ?
            WHERE item_id = ? AND user_id = ?
        ");
        return $stmt->execute([
            $this->title,
            $this->description,
            $this->price,
            $this->city,
            $this->category_id,
            $this->image_path,
            $this->id,
            $this->user_id
        ]);
    }

    public static function getItemsByPriceRange(PDO $db, float $minPrice, ?float $maxPrice): array {
        if ($maxPrice === null) {
            $stmt = $db->prepare("SELECT * FROM items WHERE price >= ? AND sold_date IS NULL");
            $stmt->execute([$minPrice]);
        } else {
            $stmt = $db->prepare("SELECT * FROM items WHERE price >= ? AND price <= ? AND sold_date IS NULL");
            $stmt->execute([$minPrice, $maxPrice]);
        }
        
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Item($row);
        }
        return $items;
    }
}
?>
