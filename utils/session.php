<?php
class Session {

    public function __construct() {
        session_start();
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getId() {
        return $_SESSION['user_id'] ?? null;
    }

    public function logout() {
        session_unset(); 
        session_destroy();
    }

    public function getUnreadMessageCount(PDO $db) {
        if (!$this->isLoggedIn()) return 0;
        $userId = $this->getId();
        $stmt = $db->prepare('SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND is_read = 0');
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
}
?>
