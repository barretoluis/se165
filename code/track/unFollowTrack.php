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
<h3>Now Unfollowing the Track</h3>
<p>Your request was successfully received.</p>

EOF;
} else {
	$msg = <<<EOF
<h3>Error Unfollowing the Track</h3>
<p>Couldn't unfollow the track. Please contact our Support team for more details</p>

EOF;
}
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Unfollow Track</title>
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
		<script src="/framework/jquery/jquery.colorbox.js"></script>
		<link href="/shared/css/colorbox.css" rel="stylesheet">
		<script>
			$(document).ready(function(){
				$('a.back').click(function(){
					parent.history.back();
					return false;
				});
			});

			function closeModal() {
				parent.jQuery.fn.colorbox.close();
				//parent.jQuery.('.bmkUrl').colorbox.close();
				//jQuery('.bmkUrl').colorbox.close();
			}

			setTimeout(closeModal, 3000);
		</script>


	</head>

	<body>
		<!-- Body Content-->
		<div class="main">
			<?php
			echo_formData($msg);
			?>
		</div>

	</body>
</html>
