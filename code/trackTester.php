<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
require_once 'includes/track.php';

$criteria = $_POST['criteria'];
$trackObj = new track();
$result = $trackObj->searchtrack($criteria);
var_dump($result);
?>
