<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
require_once 'includes/track.php';
$trackName = $_POST['name'];
$trackDescr = $_POST['desc'];
$userId = '73';
$private = $_POST['privacy'];

$trackData = array( 'userId' => $userId,
                    'title' => $trackName,
                    'desc' => $trackDescr,
                    'privacy' => $private);
$trackObj = new track();
$trackObj->createTrack($trackData);
?>
