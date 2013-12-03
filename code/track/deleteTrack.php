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
$trackId = (isset($_GET['tid'])) ? $_GET['tid'] : NULL;
$_websiteErr = Array();

if (isset($trackId) && $trackId > 0) {
	$Track = new Track();
	try {
		$resultSet = $Track->deleteTrack($trackId, $ucId);
	} catch (MyException $e) {
		array_push($_websiteErr, 'The system encountered an error and was not able to delete the track.');
		$e->getMyExceptionMessage();
	}
	// was the delete successful
	if ($resultSet == NULL) {
		array_push($_websiteErr, 'The system encountered an error and was not able to delete the track.');
	}
	unset($_SESSION['_myTracks']);

	//Get user's tracks if not available in session already
	try {
		$myTracks = new track();
		$_myTracks = $myTracks->getMyTrack($_SESSION['uc_id'], 'id,title,private');
		$_SESSION['_myTracks'] = $_myTracks;
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}

	//let's see if there were any errors
	if (count($_websiteErr) >= 1) {
		$errString = '<div class="formError"><p><b>We encountered the following issue with your request:</b></p><ol>';
		foreach ($_websiteErr as $value) {
			$errString .= "<li>" . $value . "</li>\n";
		}
		$errString .= '</ol></div>';
		$_websiteErr = $errString;
	}
} else {
	header('Location: /dashboard/');
	exit;
}
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Track | Delete Track</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Bootstrap -->
		<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- Style Sheets -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="/framework/bootstrap/assets/js/html5shiv.js"></script>
		<script src="/framework/bootstrap/assets/js/respond.min.js"></script>
		<![endif]-->

		<!-- JavaScript -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>

	</head>


	<body>
		<!-- Navigation Bar -->
		<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->


		<!-- Body Content-->
		<div class="main" >
			<h3>Delete Track</h3>
			<?php
			if (count($_websiteErr) > 0 || $_websiteErr != NULL) {
				echo $_websiteErr;
			} else {
				echo_formData('<p>The track was deleted successfully.</p>');
			}
			?>


			<!-- /Body Content-->

			<!-- Footer Content -->
			<?php require_once('html/footer.php'); ?>
			<!-- /Footer Content -->

	</body>
</html>
