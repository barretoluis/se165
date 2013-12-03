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
$_websiteErr = Array();
$formAction = (isset($_POST['formAction'])) ? $_POST['formAction'] : 'add';
$formAction = (isset($_GET['tid'])) ? 'edit' : $formAction; //since we have a track ID, let's try to edit that track
$formActionBtn = 'Add';
$trackId = (isset($_GET['tid'])) ? (int) $_GET['tid'] : NULL;
$trackId = (isset($_POST['tid'])) ? (int) $_POST['tid'] : $trackId; //POST value supersceeds GET
$ucId = (int) $_SESSION['uc_id'];
$formField = "disabled";
$updateStatus = NULL;

$trackName = (isset($_POST['name'])) ? $_POST['name'] : NULL;
$trackDescr = (isset($_POST['desc'])) ? $_POST['desc'] : NULL;
$private = (isset($_POST['privacy'])) ? $_POST['privacy'] : NULL;

if ($private == 1) {
	$private = "T";
} elseif ($private == 0) {
	$private = "F";
}



if ($formAction == "add") {
	$formActionBtn = 'Add';
	// ///////////
	// Add Track Code
	if ($trackName) {
		$Track = new Track();
		try {
			$Track->createTrack($ucId, $trackName, $trackDescr, $private);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
		unset($_SESSION['_myTracks']);

		//Get user's tracks if not available in session already
		try {
			$myTracks = new track();
			$_myTracks = $myTracks->getMyTrack($_SESSION['uc_id'], 'id,title,private');
			$_SESSION['_myTracks'] = $_myTracks;
			$formAction = 'editSaveDone';
		} catch (MyException $e) {
			$formAction = 'editSaveDone';
			array_push($_websiteErr, 'I was not able to create the requested track. You may want to try again.');
			$e->getMyExceptionMessage();
		}
	}
} elseif ($formAction == "edit") {
	// ///////////
	// Retrieve track info and populate form
	//Get the track and display it's info
	$formActionBtn = 'Update';

	try {
		$Track = new Track();
		$_track = $Track->returnMyTrackDetails($ucId, $trackId);
		if (count($_track) == 1) {
			$trackName = $_track[0]['title'];
			$trackDescr = $_track[0]['description'];
			$private = $_track[0]['private'];

			$formAction = 'editSave';
		} else {
			array_push($_websiteErr, 'We could not find any info on the track you requested.');
		}
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}
} elseif ($formAction == "editSave") {
	// ///////////
	// Save changes to DB from the edit form

	if ($trackName == NULL) {
		throw new MyException('No track name was provided.');
	} elseif ($trackDescr == NULL) {
		throw new MyException('No track description was provided.');
	} elseif ($private == NULL) {
		throw new MyException('No track privacy was provided.');
	}

	$Track = new Track();
	try {
		$Track->updateTrack($ucId, $trackId, $trackName, $trackDescr, $private);
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}
	unset($_SESSION['_myTracks']);

	//Get user's tracks if not available in session already
	try {
		$myTracks = new track();
		$_myTracks = $myTracks->getMyTrack($_SESSION['uc_id'], 'id,title,private');
		$_SESSION['_myTracks'] = $_myTracks;

		$formAction = 'editSaveDone';
	} catch (MyException $e) {
		$formAction = 'editSaveDone';
		$e->getMyExceptionMessage();
	}
}


//format any errors
if (count($_websiteErr) >= 1) {
	$errString = '<div class="formError"><p><b>We encountered the following issue with your request:</b></p><ol>';
	foreach ($_websiteErr as $value) {
		$errString .= "<li>" . $value . "</li>\n";
	}
	$errString .= '</ol></div>';
	$_websiteErr = $errString;
}
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Track</title>
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
		<!-- Body Content-->
		<?php if ($formAction != "editSaveDone") { ?>
			<div class="createTrack">
				<h3><?PHP echo_formData(ucfirst($formActionBtn)); ?> Track</h3>
				<div class="container">
					<div class="well">
						<?php
						if (count($_websiteErr) > 0 || $_websiteErr != NULL) {
							echo $_websiteErr;
						}
						?>
						<form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" name="createTrack" id="createTrack" class="form-horizontal">
							<input id="formAction" type="hidden" name="formAction" value="<?PHP echo_formData($formAction); ?>">
							<input id="tid" type="hidden" name="tid" value="<?PHP echo_formData($trackId); ?>">
							<table>
								<tr>
									<td><label>Track Name: </label></td>
									<td><input id="name" type="text" name="name" required="" value="<?php echo_formData($trackName); ?>"></td>
								</tr>
								<tr>
									<td><label>Description: </label></td>
									<td><textarea cols="30" rows="3" name="desc" id="desc" required=""><?php echo_formData($trackDescr); ?></textarea></td>
								</tr>
								<tr>
									<td><label style="padding-top:5px;">Privacy: </label></td>
									<td>
										<select name="privacy" id="privacy">
											<option value="0">Share</option>
											<option value="1">For Me</option>
										</select>
									</td>
								</tr>
							</table>
							<button class="btn btn-success" type="submit"><?PHP echo_formData(ucfirst($formActionBtn)); ?></button>
						</form>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<div class="main">
				<?php
				if (count($_websiteErr) >= 1) {
					?>
					<h3>Save Error</h3>
					<p>We were not able to save your request for the following reason. Please close this window and try again.</p>
					<?php
					if (count($_websiteErr) > 0 || $_websiteErr != NULL) {
						echo $_websiteErr;
					}
				} else {
					?>
					<script>
						function closeModal() {
							parent.jQuery.fn.colorbox.close();
						}

						setTimeout(closeModal, 3000);
					</script>
					<h3>Form Successfully Received</h3>
					<p>Your form was successfully received.</p>

					<p>This window will close automatically. <a href="javascript:closeModal(); return TRUE;">Click here</a> to close now.</p>
					<?php
				}
				?>
			</div>
		<?php } ?>

	</body>
</html>
