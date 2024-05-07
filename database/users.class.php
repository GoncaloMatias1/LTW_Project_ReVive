<?php

declare(strict_types=1);

class Users {
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public bool $is_admin;

    public function __construct(int $id, string $name, string $username, string $email, bool $is_admin) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->is_admin = $is_admin;
    }

    function save($db) {
        $stmt = $db->prepare('
        UPDATE Users SET name = ?, username = ?
        WHERE user_id = ?
        ');
        $stmt->execute([$this->name, $this->username, $this->id]);
    }

    public static function getUserLogIn(PDO $db, string $email, string $password): ?Users {
        $stmt = $db->prepare('
            SELECT user_id, name, username, email, password, is_admin
            FROM Users
            WHERE lower(email) = ?
        ');
        $stmt->execute([strtolower($email)]);
        $user = $stmt->fetch();
    
        if ($user && password_verify($password, $user['password'])) {
            return new Users(
                $user['user_id'],
                $user['name'],
                $user['username'],
                $user['email'],
                (bool)$user['is_admin']
            );
        } else {
            return null;
        }
    }    

    public static function getUser(PDO $db, int $id): ?Users {
        $stmt = $db->prepare('SELECT user_id, name, username, email, is_admin FROM users WHERE user_id = ?');
        $stmt->execute([$id]);
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new Users(
                $user['user_id'],
                $user['name'],
                $user['username'],
                $user['email'],
                (bool) $user['is_admin']  
            );
        } else {
            return null;
        }
    }    

    public static function insertUser(PDO $db, string $name, string $username, string $email, string $password, bool $is_admin = false): bool {
        $stmt = $db->prepare('
            INSERT INTO users (name, username, email, password, is_admin)
            VALUES (?, ?, ?, ?, ?)
        ');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$name, $username, $email, $hashed_password, $is_admin]);
    }

    public static function updateUser(PDO $db, int $user_id, string $name, string $email): bool {
        $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE user_id = ?");
        return $stmt->execute([$name, $email, $user_id]);
    }
}
?>
