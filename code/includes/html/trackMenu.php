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


//Variables
$ucId = (int) $_SESSION['uc_id'];
$html = NULL; //default dashboard
$_myTracks = NULL;
$loggedIn = (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) ? TRUE : FALSE;
$userName = (isset($_SESSION['profile']['first'])) ? $_SESSION['profile']['first'] : "My Profile";

//Get user's tracks if not available in session already
if (!isset($_SESSION['_myTracks'])) {
	try {
		$Track = new Track();
		$_myTracks = $Track->getMyTrack($_SESSION['uc_id'], 'id,title,private');
		$_SESSION['_myTracks'] = $_myTracks;
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}
} else {
	$_myTracks = $_SESSION['_myTracks'];
}

$defaultTrackId = $Track->returnDefaultTrackId($ucId);
$defaultTrackName = $Track->returnTrackName($defaultTrackId);
$html = '<li class="private"><a href="/dashboard/">' . $defaultTrackName . '</a>'; //default dashboard

foreach ($_myTracks as $dbRow) {
	$isPrivate = ($dbRow['private'] == "T") ? TRUE : FALSE;

	//we don't want the default track in the list again
	if ($dbRow['id'] != $defaultTrackId) {
		foreach ($dbRow as $key => $value) {
			switch ($key) {
				case 'id':
					if ($isPrivate) {
						$html .= '<li class="private"><a href="/dashboard/?tid=' . $value . '">';
					} else {
						$html .= '<li><a href="/dashboard/?tid=' . $value . '">';
					}
					break;

				case 'title':
					$html .= $value . "</a></li>\n";
					break;

				default:
					break;
			}
		}
	}
}
?>



<?php if ($loggedIn) { //show logged in-nav    ?>
	<div id="sidr">
		<div align="right" style="margin: 5px 15px 5px 15px;"><a id="simple-menu2" href="#sidr"><small>(close menu)</small></a></div>
		<ul>
			<li style="margin-left: 5px;"><b>My Tracks</b></li>
			<?php
			echo_formData($html);
			?>
		</ul>
		<ul>
			<li style="margin-left: 5px;"><b>Following Tracks</b></li>
			<li><a href="#">To implement</a></li>
			<li class="active"><a href="#">To implement</a></li>
			<li><a href="#">To implement</a></li>
		</ul>
	</div>


<?php } else { //show standard nav    ?>


<?php } ?>
