<?php
session_start();

$profile = $_SESSION['profile'];
$fbButton = $_SESSION['logoutURL'];
echo $fbButton;
echo "<p>Dashboard</p>";
print_r($profile);
?>
