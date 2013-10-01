<?php
require_once 'includes/user.php';
session_Start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
$userObj = new user();
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$gender = $_POST['sex'];
$password = $_POST['pwd'];
$password2 = $_POST['pwd2'];
$userArray = array('fname'=>$fname,
                   'lname'=>$lname,
                   'email'=>$email,
                   'password'=>$password,
                   'gender'=>$gender,
                   'source' => 'S');
$userObj->createUSer($userArray);

echo "<p>Register Page</p>";

echo "<p>$fname</p>";
echo "<p>$lname</p>";
echo "<p>$email</p>";
echo "<p>$gender</p>";
echo "<p>$password</p>";
echo "<p>$password2</p>";





/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
