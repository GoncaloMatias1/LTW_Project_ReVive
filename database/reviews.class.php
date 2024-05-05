<?php

class Reviews {
    public static function addReview(PDO $db, int $userId, int $itemId, int $rating, string $comment): bool {
        $stmt = $db->prepare("INSERT INTO reviews (user_id, item_id, rating, comment, review_date) VALUES (?, ?, ?, ?, ?)");
        
        $currentDate = date('Y-m-d H:i:s');
        
        return $stmt->execute([$userId, $itemId, $rating, $comment, $currentDate]);
    }

    public static function getReviewsByUser(PDO $db, int $userId): array {
        $stmt = $db->prepare("SELECT items.title, reviews.rating, reviews.comment, reviews.review_date FROM reviews JOIN items ON reviews.item_id = items.item_id WHERE reviews.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getReviewsByItem(PDO $db, int $itemId): array {
        $stmt = $db->prepare("SELECT users.username, reviews.rating, reviews.comment, reviews.review_date FROM reviews JOIN users ON reviews.user_id = users.user_id WHERE reviews.item_id = ?");
        $stmt->execute([$itemId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
