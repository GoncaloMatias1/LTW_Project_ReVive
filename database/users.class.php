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

        function save($db) {
            $stmt = $db->prepare('
            UPDATE Users SET name = ?, username = ?
            WHERE user_id = ?
            ');

            $stmt->execute(array($this->name, $this->username, $this->id));
        }

        static function getUser(PDO $db, string $email, string $password) : ?User {

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
    }

?>