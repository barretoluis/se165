<?php/* * Add additional include files to array if needed for this page. */$includeFilesAdditional = array(	'Bookmark/Bookmark.class.php');// DO NOT EDIT THIS BLOCK - START/* * Require mandatory libraries to be loaded. * Else, redirect to server outage page. * */try {	// require the primary include file	if (!include_once('main.php')) {		throw new Exception("Unable to include the main library.\n");	}} catch (Exception $e) {	throw new Exception('Was not able to include the main.php file.', 0, $e);	header('HTTP/1.1 500 Internal Server Error', true, 500);	exit(0);}// DO NOT EDIT THIS BLOCK - END/* * Page specific PHP code here */$_websiteErr = Array();$_followingTracks = Array();//$bookmarkId = (isset($_GET['bid'])) ? (int) $_GET['bid'] : NULL;$trackId = (isset($_POST['tid'])) ? (int) $_POST['tid'] : NULL;$url = (isset($_POST['url'])) ? $_POST['url'] : NULL;$privacy = (isset($_POST['privacy'])) ? (int) $_POST['privacy'] : NULL;$description = (isset($_POST['description'])) ? $_POST['description'] : NULL;$keyword = (isset($_POST['keywords'])) ? $_POST['keywords'] : NULL;$imageSrc = (isset($_POST['imageSrc'])) ? $_POST['imageSrc'] : NULL;$descriptionErr = NULL;$keywordsErr = NULL;$urlErr = NULL;$flagEnable = FALSE;$defaultTrack = NULL;if ($_SERVER["REQUEST_METHOD"] == "POST") {	$flagEnable = TRUE;	if ($url == NULL) {		array_push($_websiteErr, 'Please complete the URL field.');	}	if ($description == NULL) {		array_push($_websiteErr, 'Please complete the Description field.');	}	if ($keyword == NULL) {		array_push($_websiteErr, 'Please complete the Keywords field.');	}}if ($trackId != NULL) {	if (count($_websiteErr) == 0) {		try {			$Bookmark = new Bookmark();			$friendlyErrors = $Bookmark->createBookmark($trackId, $url, $privacy, $description, $keyword, $imageSrc);			if ($friendlyErrors != null) {				array_push($_websiteErr, $friendlyErrors);			}		} catch (MyException $e) {			//$e->getMyExceptionMessage();  //DEBUG			array_push($_websiteErr, $e->getMessage());		}		if (count($_websiteErr) >= 1) {			$errString = '<div class="formError"><p><b>We encountered the following issue with your request:</b></p><ol>';			foreach ($_websiteErr as $value) {				$errString .= "<li>" . $value . "</li>\n";			}			$errString .= '</ol></div>';			$_websiteErr = $errString;		} else {			include 'html/formSuccess.php';			exit;		}	}}//Get the user's default track$myTracks = new track();$defaultTrackId = $myTracks->returnDefaultTrackId($ucId);if ($defaultTrackId != null) {	$defaultTrack = $myTracks->returnMyTrackDetails($_SESSION['uc_id'], $defaultTrackId);}//Get user's tracks if not available in session alreadyif (!isset($_SESSION['_myTracks']) || !isset($_SESSION['_followingTracks'])) {	try {		$_myTracks = $myTracks->getMyTrack($_SESSION['uc_id'], 'id,title');		$_followingTracks = $myTracks->returnFollowingTracks($_SESSION['uc_id'], 'id,title,private');		$defaultTrackId = $myTracks->returnDefaultTrackId($ucId);		if ($defaultTrackId != null) {			$defaultTrack = $myTracks->returnMyTrackDetails($_SESSION['uc_id'], $defaultTrackId);		}		$_SESSION['_myTracks'] = $_myTracks;		$_SESSION['_followingTracks'] = $_followingTracks;	} catch (MyException $e) {		$e->getMyExceptionMessage();	}}//Let's populate the option menu with the user's tracksif (isset($_SESSION['_myTracks'])) {	$trackString = '<select name="tid" id="tid" disabled>';	//$trackString .= '<option value="-1" class="">Select Track</option>';	// we get the default track	if ($defaultTrack != NULL) {		foreach ($defaultTrack as $_record) {			$id = $_record['id'];			$title = $_record['title'];			$private = (isset($_record['private']) && $_record['private'] == 1) ? 'private' : '';			$trackString .= '<option value="' . $id . '" class="' . $private . '">' . $title . '</option>';		}	}	foreach ($_SESSION['_myTracks'] as $_record) {		$id = $_record['id'];		$title = $_record['title'];		$private = (isset($_record['private']) && $_record['private'] == 1) ? 'private' : '';		$trackString .= '<option value="' . $id . '" class="' . $private . '">' . $title . '</option>';	}	$trackString .= '</select>';}/* * Format any page errors to show user on webpage. */if (count($_websiteErr) >= 1) {	$errString = '<div class="formError"><p><b>We encountered the following issue with your request:</b></p><ol>';	foreach ($_websiteErr as $value) {		$errString .= "<li>" . $value . "</li>\n";	}	$errString .= '</ol></div>';	$_websiteErr = $errString;}?><!DOCTYPE html><html>	<head>		<title>Tackster | Bookmark</title>		<meta name="viewport" content="width=device-width, initial-scale=1.0">		<meta name="description" content="">		<meta name="author" content="">		<!-- Bootstrap -->		<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">		<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">		<!-- Style Sheets -->		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.min.css" rel="stylesheet"> <!--for delete and edit icons-->		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->		<!--[if lt IE 9]>		<script src="/framework/bootstrap/assets/js/html5shiv.js"></script>		<script src="/framework/bootstrap/assets/js/respond.min.js"></script>		<![endif]-->		<!-- JavaScript -->		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>		<!-- Include all compiled plugins (below), or include individual files as needed -->		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>		<script src="/shared/js/bookmarkForm-addEdit.js"></script>		<script>			$(function() {				$( document ).tooltip({					track: true				});			});		</script>	</head>	<body>		<script>			$('#submit_id').click($.colorbox.close());		</script>		<!-- Body Content-->		<div class="bookmark">			<h3>Add Bookmark</h3>			<div class="container">				<div class="well">					<?php					if (count($_websiteErr) > 0 || $_websiteErr != NULL) {						echo $_websiteErr;					}					?>					<form class="form-horizontal" id="createBookmark" name="createBookmark" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">						<table>							<tr>								<td><label>URL: </label></td>								<td>									<input id="url" style="width:325px" type="text" name="url" onfocus="resetData();" maxlength="255" value="<?php echo_formData($url); ?>" required placeholder="http://www.somesite.com">									<div style="z-index: 10; display: compact; float:right; max-width: 150px;"><button id="urlNext" class="btn btn-success btn-block" type="button" onClick="processUrl(url.value);">Next</button></div>									<br><span class="text-error"><?php //echo $urlErr; ?></span>								</td>							</tr>							<tr>								<td><label style="padding-top:5px;">Keywords: </label></td>								<td>									<input id="keywords" type="text" name="keywords" value="<?php echo_formData($keyword); ?>" placeholder="Comma Seperated List" disabled required>									<br><span class="text-error"><?php //echo $keywordsErr; ?></span>								</td>							</tr>							<tr>								<td><label style="padding-top:5px;">Description:</label></td>								<td><textarea name="description" rows="3" disabled><?php echo_formData($description); ?></textarea>									<br><span class="text-error"><?php //echo $descriptionErr; ?></span>								</td>							</tr>							<tr>								<td><label style="padding-top:5px;">Add to Track: </label></td>								<td>									<?php echo_formData($trackString); ?>								</td>							</tr>							<tr>								<td><label style="padding-top:5px;">Privacy: </label></td>								<td>									<select name="privacy" id="privacy" disabled >										<option value="0">Share</option>										<option value="1">For Me</option>									</select>								</td>							</tr>							<tr>								<td><label>Thumbnail: </label></td>								<td><input id="imageSrc" type="hidden" name="imageSrc">									<img id="timage" style="max-height: 150px; max-width: 200px;" class="img-polaroid" src="<?php if ($imageSrc != null) echo $imageSrc; else echo "/shared/images/placeholder.jpg"; ?>">									<div style="display: compact; float:right; max-width: 150px;"><button id="selectImgBtn" class="btn btn-success btn-block" style="visibility: hidden;" type="button" onclick="displayImages()">Select an Image</button></div>									<div style="max-height:200px; overflow: auto; visibility: hidden;"id="sitePictures" >										<h4>Please enter the URL first.</h4>									</div> <!--- /site pictures -->								</td>							</tr>						</table>						<button class="btn btn-success" type="submit" id="submit_id">Submit</button>					</form>				</div>			</div>		</div>		<?php		if ($flagEnable) {			echo "<script>checkStatus();</script>";		}		?>		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />		<script>			//Script to handle autocomplete for keywords with CSVs			$(document).ready(function($){				$('#keywords').autocomplete({source:function (request, response) {						$.getJSON("../search/autocomplete.php", {							term: extractLast(request.term)						}, response);					},					//Jquery events to handle					search: function () {						var term = extractLast(this.value);						// Set length you want autocomplete to start searching at						if (term.length < 1) {							return false;						}					},					focus: function () {						// prevent value inserted on focus						return false;					},					appendTo: $("#keywords").next(),					select: function (event, ui) {						var terms = split(this.value);						// remove the current input						terms.pop();						// add the selected item						terms.push(ui.item.value);						// add placeholder to get the comma-and-space at the end						terms.push("");						this.value = terms.join(", ");						return false;					}, minLength:1});			});			function split(val) {				return val.split(/,\s*/);			}			function extractLast(term) {				return split(term).pop();			}		</script>		<!-- /Body Content-->	</body></html>