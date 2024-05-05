<?php

class Wishlist {
    public static function addToWishlist(PDO $db, int $userId, int $itemId): bool {
        $stmt = $db->prepare("INSERT INTO wishlist (user_id, item_id) VALUES (?, ?) ON CONFLICT (user_id, item_id) DO NOTHING");
        return $stmt->execute([$userId, $itemId]);
    }

    public static function removeFromWishlist(PDO $db, int $userId, int $itemId): bool {
        $stmt = $db->prepare("DELETE FROM wishlist WHERE user_id = ? AND item_id = ?");
        return $stmt->execute([$userId, $itemId]);
    }    

    public static function isItemInWishlist(PDO $db, int $userId, int $itemId): bool {
        $stmt = $db->prepare("SELECT 1 FROM wishlist WHERE user_id = ? AND item_id = ?");
        $stmt->execute([$userId, $itemId]);
        return (bool) $stmt->fetchColumn();
    }

    public static function getUserWishlist(PDO $db, int $userId): array {
        $stmt = $db->prepare("SELECT items.* FROM items JOIN wishlist ON items.item_id = wishlist.item_id WHERE wishlist.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
