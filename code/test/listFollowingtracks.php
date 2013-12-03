<?php

require_once '../includes/Track/Track.class.php';
//require_once '../includes/DataBase.php';
error_reporting(E_ALL);
ini_set('display_errors', 'On');



// DO NOT EDIT THIS BLOCK - START
/*
 * Require mandatory libraries to be loaded.
 * Else, redirect to server outage page.
 *
 */

// DO NOT EDIT THIS BLOCK - END

//$_followingTracks = array();
$ucId = '97';
echo "<p>UC ID</p>";
$Track = new Track();
$Track->returnFollowingTracksv2($ucId);
echo "<p>end</p>";


?>
