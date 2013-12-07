<?php

require_once '../includes/Track/Track.class.php';
//require_once '../includes/DataBase.php';
$tid = $_GET['tid'];
$Track = new Track();
$Track->unFollowTrack($tid, $ucId);

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
