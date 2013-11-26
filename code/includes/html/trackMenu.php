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
$htmlMyTrack = NULL; //default dashboard
$htmlFollowTrack = NULL; //default dashboard
$_myTracks = array();
$_followingTracks = array();
$loggedIn = (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) ? TRUE : FALSE;
$userName = (isset($_SESSION['profile']['first'])) ? $_SESSION['profile']['first'] : "My Profile";
$onTrackId = (isset($onTrackId)) ? (int) $onTrackId : NULL; //tid of track being viewed. Set on /track/index.php file
$Track = new Track();

//Get user's tracks if not available in session already
if (!isset($_SESSION['_myTracks']) || !isset($_SESSION['_followingTracks'])) {
	try {
		$_myTracks = $Track->getMyTrack($_SESSION['uc_id'], 'id,title,private');
		$_followingTracks = $Track->returnFollowingTracks($_SESSION['uc_id'], 'id,title,private');
		$_SESSION['_myTracks'] = $_myTracks;
		$_SESSION['_followingTracks'] = $_followingTracks;
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}
} else {
	$_myTracks = $_SESSION['_myTracks'];
	$_followingTracks = $_SESSION['_followingTracks'];
}

$defaultTrackId = $Track->returnDefaultTrackId($ucId);
$defaultTrackName = $Track->returnTrackName($defaultTrackId);
$isActiveClassName = ($onTrackId == $defaultTrackId) ? 'active' : NULL;
$htmlMyTrack = '<li class="private ' . $isActiveClassName . '"><a href="/track/">' . $defaultTrackName . '</a>'; //default dashboard

foreach ($_myTracks as $dbRow) {
	$isPrivate = ($dbRow['private'] == "T") ? TRUE : FALSE;
	$isActiveClassName = ($dbRow['id'] == $onTrackId) ? 'active' : NULL;

	//we don't want the default track in the list again
	if ($dbRow['id'] != $defaultTrackId) {
		foreach ($dbRow as $key => $value) {
			switch ($key) {
				case 'id':
					if ($isPrivate) {
						$htmlMyTrack .= '<li class="private ' . $isActiveClassName . '"><a href="/track/?tid=' . $value . '">';
					} else {
						$htmlMyTrack .= '<li class="' . $isActiveClassName . '"><a href="/track/?tid=' . $value . '">';
					}
					break;

				case 'title':
					$htmlMyTrack .= $value . "</a></li>\n";
					break;

				default:
					break;
			}
		}
	}
}

if (is_array($_followingTracks) && count($_followingTracks) > 0) {
	foreach ($_followingTracks as $dbRow) {
		$isPrivate = ($dbRow['private'] == "T") ? TRUE : FALSE;
		$isActiveClassName = ($dbRow['id'] == $onTrackId) ? 'active' : NULL;

		//we don't want the default track in the list again
		if ($dbRow['id'] != $defaultTrackId) {
			foreach ($dbRow as $key => $value) {
				switch ($key) {
					case 'id':
						if ($isPrivate) {
							$htmlFollowTrack .= '<li class="private ' . $isActiveClassName . '"><a href="/track/?tid=' . $value . '">';
						} else {
							$htmlFollowTrack .= '<li class="' . $isActiveClassName . '"><a href="/track/?tid=' . $value . '">';
						}
						break;

					case 'title':
						$htmlFollowTrack .= $value . "</a></li>\n";
						break;

					default:
						break;
				}
			}
		}
	}
}
?>
<script>
    $(document).ready(function() {

        //jQuery("#simple-menu2").colorbox.close();
		$('#simple-menu2').colorbox.close();
    });

</script>


<?php if ($loggedIn) { //show logged in-nav      ?>
	<div id="sidr">
		<div align="right" style="margin: 5px 15px 5px 15px;"><a id="simple-menu2" href="#sidr">X</a></div>
		<ul>
			<li style="margin-left: 5px;"><b>My Tracks</b></li>
			<?php
			echo_formData($htmlMyTrack);
			?>
		</ul>
		<ul>
			<?php
			if ($htmlFollowTrack) {
				echo '<li style="margin-left: 5px;"><b>Following Tracks</b></li>';
			}
			echo_formData($htmlFollowTrack);
			?>
		</ul>
	</div>


<?php } else { //show standard nav      ?>


<?php } ?>
