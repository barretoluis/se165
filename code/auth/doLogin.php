<?php

    require_once 'includes/user.php';
    $userObj = new user();
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userObj->logInUser($username, $password);
?>
