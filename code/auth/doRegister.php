<?php
  require_once 'includes/user.php';
  session_Start();

  $userObj = new user();
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $userArray = array('fname'=>$fname,'lname'=>$lname,
  'email'=>$email,
  'password'=>$password,
  'source' => 'S');
  $userObj->createUSer($userArray);

?>
