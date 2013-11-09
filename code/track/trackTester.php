<?php
session_start();
require_once 'Track/Track.class.php';

$criteria = $_POST['criteria'];
$trackObj = new Track();
$result = $trackObj->searchtrack($criteria);
var_dump($result);
?>
