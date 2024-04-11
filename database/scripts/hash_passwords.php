<?php
$users = [
    ['Gonçalo Gonçalves', 'GGgoat', 'senhaGoncalo', 'goncalogoat@example.com', 0],
    ['Pedro Flácido', 'PedroDuro', 'senhaPedro', 'pedroflacido@example.com', 1],
];

$sql = "INSERT INTO users (name, username, password, email, is_admin) VALUES\n";

foreach ($users as $index => $user) {
    $hashed_password = password_hash($user[2], PASSWORD_DEFAULT);
    $sql .= sprintf(
        "(%s, %s, %s, %s, %s)%s",
        var_export($user[0], true), // Name
        var_export($user[1], true), // Username
        var_export($hashed_password, true), // Hashed password
        var_export($user[3], true), // Email
        var_export($user[4], true), // Is_admin
        $index < count($users) - 1 ? ",\n" : ";\n"
    );
}

file_put_contents('populate_with_hashes.sql', $sql);
?>
