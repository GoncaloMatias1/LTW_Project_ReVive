<?php

declare(strict_types = 1);

class User {
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public bool $is_admin;

    public function __construct(int $id, string $name, string $username, string $email, bool $is_admin)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->is_admin = $is_admin;
    }

    function save(PDO $db) {
        $stmt = $db->prepare('
        UPDATE Users SET name = ?, username = ?
        WHERE user_id = ?
        ');

        $stmt->execute(array($this->name, $this->username, $this->id));
    }

    static function getUserLogIn(PDO $db, string $email, string $password) : ?User {

        $stmt = $db->prepare ('
        SELECT user_id, name, username, email, is_admin
        FROM Users
        WHERE lower(email) = ? AND password = ?
        ');

        $stmt->execute(array(strtolower($email), sha1($password)));

        if($user = $stmt->fetch()){
            return new User(
                $user['user_id'],
                $user['name'],
                $user['username'],
                $user['email'],
                $user['is_admin']
            );
        }
        else return null;
    }

    static function getUser(PDO $db, int $id){

        $stmt = $db->prepare('
        SELECT user_id, name, username, email, is_admin
        FROM Users
        WHERE user_id = ?
        ');

        $stmt->execute(array($id));

        $user = $stmt->fetch();

        return new User(
            $user['user_id'],
            $user['name'],
            $user['username'],
            $user['email'],
            $user['is_admin']                
        );
    }

    static function insertUser(PDO $db, string $name, string $username, string $email, string $password, bool $is_admin = false): bool {
        $stmt = $db->prepare('
            INSERT INTO Users (name, username, email, password, is_admin)
            VALUES (?, ?, ?, ?, ?)
        ');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$name, $username, $email, $hashed_password, $is_admin]);
    }
}
?>
