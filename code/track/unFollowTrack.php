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
$ucId = (isset($_SESSION['uc_id'])) ? (int) $_SESSION['uc_id'] : NULL;
$tid = (isset($_GET['tid'])) ? (int) $_GET['tid'] : NULL;
$bid = (isset($_GET['bid'])) ? (int) $_GET['bid'] : NULL;

try {
	$trackObj = new Track();
	$status = $trackObj->unfollowTrack($tid, $ucId);

} catch (MyException $e) {
	$status = FALSE;
}

if ($status) {
	$msg = <<<EOF
<META http-equiv="refresh" content="4;URL=/dashboard">
<h3>Now Unfollowing the Track</h3>
<p style="padding-left: 5px;">The track was deleted successfully. This page will automatically refresh or <a href="/dashboard/">click here to go to the Dashboard</a>.</p>
EOF;
} else {
	$msg = <<<EOF
<META http-equiv="refresh" content="4;URL=/dashboard">
<h3>Error Unfollowing the Track</h3>
<p style="padding-left: 5px;">Couldn't unfollow the track. Please contact our Support team for more details.</p>
<p style="padding-left: 5px;">This page will automatically refresh or <a href="/dashboard/">click here to go to the Dashboard</a>.</p>
EOF;
}
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Track | Unfollow Track</title>
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
				echo_formData('<META http-equiv="refresh" content="4;URL=/dashboard">');
				echo_formData('<p style="padding-left: 5px;">The track was deleted successfully. This page will automatically refresh or <a href="/dashboard/">click here to go to the Dashboard</a>.</p>');
			}
			?>


			<!-- /Body Content-->

			<!-- Footer Content -->
			<?php require_once('html/footer.php'); ?>
			<!-- /Footer Content -->

	</body>
</html>
