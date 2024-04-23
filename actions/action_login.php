<?php

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    $db = getDatabaseConnection();

    $user = User::getUserLogIn($db, $_POST['email'], $_POST['password']);

    if ($user) {
        $session->setId($user->id);
        $session->setName($user->username());
        $session->addMessage('success', 'Login successful!');
      } else {
        $session->addMessage('error', 'Wrong password!');
      }
    

?>