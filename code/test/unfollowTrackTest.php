<?php
require_once '../includes/Track/Track.class.php';
//require_once '../includes/DataBase.php';
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$ucId = '0';
$tid = '0';
$Track = new Track();
$Track->unFollowTrack($ucId, $tid);


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
