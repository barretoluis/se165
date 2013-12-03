<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
	'Bookmark/Bookmark.class.php',
        'Track/Track.class.php'
);




// DO NOT EDIT THIS BLOCK - START
/*
 * Require mandatory libraries to be loaded.
 * Else, redirect to server outage page.
 *
 */
try {
	// require the primary include file
	if (!include_once('main.php')) {
		throw new Exception("Unable to include the main library.\n");
	}
} catch (Exception $e) {
	throw new Exception('Was not able to include the main.php file.', 0, $e);
	header('HTTP/1.1 500 Internal Server Error', true, 500);
	exit(0);
}
// DO NOT EDIT THIS BLOCK - END
    $ucid = $_GET['ucid'];
    $tid = $_GET['tid'];
    $trackObj = new Track();
    $status = $trackObj->followTrack($ucid, $tid);
    if ($status)
    {
        echo "Track Added successfuly.";
        
    }
    else
    {
        echo "Could not follow the track";
    }

?>

