<?php
session_start();
require_once 'includes/track.php';

$criteria = $_POST['criteria'];
$trackObj = new track();
$result = $trackObj->searchtrack($criteria);
var_dump($result);
?>
