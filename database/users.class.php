<?php

declare(strict_types=1);

class Users {
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public bool $is_admin;
    public ?string $street;
    public ?string $door;
    public ?string $city;
    public ?string $state;
    public ?string $postalCode;

    public function __construct(int $id, string $name, string $username, string $email, bool $is_admin, ?string $street = null, ?string $door = null, ?string $city = null, ?string $state = null, ?string $postalCode = null) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->is_admin = $is_admin;
        $this->street = $street;
        $this->door = $door;
        $this->city = $city;
        $this->state = $state;
        $this->postalCode = $postalCode;
    }

    function save($db) {
        $stmt = $db->prepare('
        UPDATE users SET name = ?, username = ?, street = ?, door = ?, city = ?, state = ?, postalCode = ?
        WHERE user_id = ?
        ');
        $stmt->execute([$this->name, $this->username, $this->street, $this->door, $this->city, $this->state, $this->postalCode, $this->id]);
    }

    public static function getUserLogIn(PDO $db, string $email, string $password): ?Users {
        $stmt = $db->prepare('
            SELECT user_id, name, username, email, password, is_admin, street, door, city, state, postalCode
            FROM users
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
                (bool)$user['is_admin'],
                $user['street'],
                $user['door'],
                $user['city'],
                $user['state'],
                $user['postalCode']
            );
        } else {
            return null;
        }
    }    

    public static function getUser(PDO $db, int $id): ?Users {
        $stmt = $db->prepare('SELECT user_id, name, username, email, is_admin, street, door, city, state, postalCode FROM users WHERE user_id = ?');
        $stmt->execute([$id]);
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return new Users(
                $user['user_id'],
                $user['name'],
                $user['username'],
                $user['email'],
                (bool) $user['is_admin'],
                $user['street'],
                $user['door'],
                $user['city'],
                $user['state'],
                $user['postalCode']
            );
        } else {
            return null;
        }
    }
     

    public static function insertUser(PDO $db, string $name, string $username, string $email, string $password, bool $is_admin = false): array {
        $stmt = $db->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return ['success' => false, 'message' => 'Email already exists'];
        }

        $stmt = $db->prepare('
            INSERT INTO users (name, username, email, password, is_admin, street, door, city, state, postalCode)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ');
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $result = $stmt->execute([$name, $username, $email, $hashed_password, $is_admin, null, null, null, null, null]);

        if ($result) {
            return ['success' => true, 'message' => 'User registered successfully'];
        } else {
            return ['success' => false, 'message' => 'Error registering user'];
        }
    }

    public static function updateUser(PDO $db, int $user_id, string $name, string $username, string $email, ?string $street = null, ?string $door = null, ?string $city = null, ?string $state = null, ?string $postalCode = null, ?string $password = null): bool {
        $query = "UPDATE users SET name = ?, username = ?, email = ?, street = ?, door = ?, city = ?, state = ?, postalCode = ?";
        $params = [$name, $username, $email, $street, $door, $city, $state, $postalCode];
        if ($password) {
            $query .= ", password = ?";
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $params[] = $hashed_password;
        }
        $query .= " WHERE user_id = ?";
        $params[] = $user_id;
        
        $stmt = $db->prepare($query);
        return $stmt->execute($params);
    }    
    
    public static function makeAdmin(PDO $db, int $user_id){
        $query = "UPDATE users SET is_admin = 1 WHERE user_id = ?";
        $params[] = $user_id;

        $stmt = $db-> prepare($query);
        return $stmt->execute($params);
    }

    public static function removeAdmin(PDO $db, int $user_id){
        $query = "UPDATE users SET is_admin = 0 WHERE user_id = ?";
        $params[] = $user_id;

        $stmt = $db-> prepare($query);
        return $stmt->execute($params);
    }
}
?>
