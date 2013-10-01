<?php
require_once 'includes/user.php';
$userObj = new user();
session_start();
$email = $_POST['email'];
$pwd = $_POST['password'];
$userObj->logInUser($email, $pwd);
?>
