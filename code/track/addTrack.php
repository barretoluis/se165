<?php

/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
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




/*
 * Page specific PHP code here
 */
$ucId = (int) $_SESSION['uc_id'];
$trackName = (isset($_POST['name'])) ? $_POST['name'] : NULL;
$trackDescr = (isset($_POST['desc'])) ? $_POST['desc'] : NULL;
$private = (isset($_POST['privacy'])) ? $_POST['privacy'] : NULL;

if ($trackName) {
	$Track = new Track();
	$Track->createTrack($ucId, $trackName, $trackDescr, $private);
	unset($_SESSION['_myTracks']);

	//Get user's tracks if not available in session already
	try {
		$myTracks = new track();
		$_myTracks = $myTracks->getMyTrack($_SESSION['uc_id'], 'id,title,private');
		$_SESSION['_myTracks'] = $_myTracks;
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}
} else {
	header('Location: /dashboard/');
	exit;
}
?>
