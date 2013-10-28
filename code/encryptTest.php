<?php
require_once 'includes/user.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
$userObj = new user();

echo $userObj->encyptPwd("pelusa2k2");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
