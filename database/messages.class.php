<?php

class Message {
    public int $id;
    public int $sender_id;
    public int $receiver_id;
    public int $item_id;
    public string $message;
    public string $timestamp;
    public int $is_read;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? 0;
        $this->sender_id = $data['sender_id'] ?? 0;
        $this->receiver_id = $data['receiver_id'] ?? 0;
        $this->item_id = $data['item_id'] ?? 0;
        $this->message = $data['message'] ?? '';
        $this->timestamp = $data['timestamp'] ?? '';
        $this->is_read = $data['is_read'] ?? 0;
    }

    public function save(PDO $db) {
        $stmt = $db->prepare('INSERT INTO messages (sender_id, receiver_id, item_id, message, timestamp, is_read) VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$this->sender_id, $this->receiver_id, $this->item_id, $this->message, $this->timestamp, $this->is_read]);
    }

    public static function getMessages(PDO $db, int $user_id, int $receiver_id, int $item_id): array {
        $stmt = $db->prepare('
            SELECT * 
            FROM messages 
            WHERE (sender_id = ? AND receiver_id = ? OR sender_id = ? AND receiver_id = ?) 
            AND item_id = ? 
            ORDER BY timestamp ASC
        ');
        $stmt->execute([$user_id, $receiver_id, $receiver_id, $user_id, $item_id]);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Mark messages as read
        $stmt = $db->prepare('UPDATE messages SET is_read = 1 WHERE receiver_id = ? AND sender_id = ? AND item_id = ?');
        $stmt->execute([$user_id, $receiver_id, $item_id]);
    
        return $messages;
    }    

    public static function sendMessage(PDO $db, int $sender_id, int $receiver_id, int $item_id, string $message): bool {
        $stmt = $db->prepare('INSERT INTO messages (sender_id, receiver_id, item_id, message) VALUES (?, ?, ?, ?)');
        return $stmt->execute([$sender_id, $receiver_id, $item_id, $message]);
    }

    public static function getConversations(PDO $db, int $user_id): array {
        $stmt = $db->prepare('
            SELECT m.item_id, 
                   CASE 
                       WHEN m.sender_id = ? THEN m.receiver_id 
                       ELSE m.sender_id 
                   END as other_user_id,
                   u.username, i.title
            FROM messages m
            JOIN users u ON u.user_id = CASE 
                                           WHEN m.sender_id = ? THEN m.receiver_id 
                                           ELSE m.sender_id 
                                       END
            JOIN items i ON m.item_id = i.item_id
            WHERE m.sender_id = ? OR m.receiver_id = ?
            GROUP BY m.item_id, other_user_id
        ');
        $stmt->execute([$user_id, $user_id, $user_id, $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
