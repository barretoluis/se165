<?php/* * Add additional include files to array if needed for this page. */$includeFilesAdditional = array(	'Bookmark/Bookmark.class.php');// DO NOT EDIT THIS BLOCK - START/* * Require mandatory libraries to be loaded. * Else, redirect to server outage page. * */try {	// require the primary include file	if (!include_once('main.php')) {		throw new Exception("Unable to include the main library.\n");	}} catch (Exception $e) {	throw new Exception('Was not able to include the main.php file.', 0, $e);	header('HTTP/1.1 500 Internal Server Error', true, 500);	exit(0);}// DO NOT EDIT THIS BLOCK - END/* * Page specific PHP code here */$_websiteErr = Array();$_followingTracks = Array();$bookmarkId = (isset($_GET['bid'])) ? (int) $_GET['bid'] : NULL;$bmkId = (isset($_POST['bid'])) ? (int) $_POST['bid'] : NULL;$trackId = (isset($_POST['tid'])) ? (int) $_POST['tid'] : NULL;$url = (isset($_POST['url'])) ? $_POST['url'] : NULL;$privacy = (isset($_POST['privacy'])) ? (int) $_POST['privacy'] : NULL;$description = (isset($_POST['description'])) ? $_POST['description'] : NULL;$keyword = (isset($_POST['keyword'])) ? $_POST['keyword'] : NULL;$imageSrc = (isset($_POST['imageSrc'])) ? $_POST['imageSrc'] : NULL;$formFlag = (isset($_POST['formFlag'])) ? $_POST['formFlag'] : NULL;$success = FALSE;// ///////////// Retrieve track info and populate form//Get the track and display it's infoif ($bookmarkId != NULL) {	try {		$Bookmark = new Bookmark();		$_bookmark = $Bookmark->returnBookmark($_GET['bid']);		if (count($_bookmark) == 1) {			$trackId = $_bookmark[0]['t_id'];			$url = $_bookmark[0]['url'];			$description = $_bookmark[0]['description'];			$imageSrc = $_bookmark[0]['bmk_image'];			$keyword = $_bookmark[0]['keyword'];			$privacy = $_bookmark[0]['privacy'];		} else {			array_push($_websiteErr, 'We could not find any info on the bookmark you requested.');		}	} catch (MyException $e) {		$e->getMyExceptionMessage();	}}if ($formFlag == TRUE) {	// ///////////	// Save changes to DB from the edit form	if ($url == NULL) {		throw new MyException('No URL was provided');	} elseif ($description == NULL) {		throw new MyException('No description was provided.');	} elseif ($imageSrc == NULL) {		throw new MyException('No image was provided.');	} elseif ($keyword == NULL) {		throw new MyException('No keyword was provided.');	}	$Bookmark = new Bookmark();	try {		$success = $Bookmark->updateBookmark($bmkId, $trackId, $url, $description, $keyword, $privacy, $imageSrc);	} catch (MyException $e) {		$e->getMyExceptionMessage();	}	if ($success == TRUE) {		include 'html/formSuccess.php';		exit;	}}//Get the user's default track$myTracks = new track();$defaultTrackId = $myTracks->returnDefaultTrackId($ucId);if ($defaultTrackId != null) {	$defaultTrack = $myTracks->returnMyTrackDetails($_SESSION['uc_id'], $defaultTrackId);}//Get user's tracks if not available in session alreadyif (!isset($_SESSION['_myTracks']) || !isset($_SESSION['_followingTracks'])) {	try {		$myTracks = new track();		$_myTracks = $myTracks->getMyTrack($_SESSION['uc_id'], 'id,title');		$_followingTracks = $myTracks->returnFollowingTracks($_SESSION['uc_id'], 'id,title,private');		$_SESSION['_myTracks'] = $_myTracks;		$_SESSION['_followingTracks'] = $_followingTracks;	} catch (MyException $e) {		$e->getMyExceptionMessage();	}}//Let's populate the option menu with the user's tracksif (isset($_SESSION['_myTracks'])) {	$trackString = '<select name="tid" id="tid">';	//$trackString .= '<option value="-1" class="">Select Track</option>';	// we get the default track	if ($defaultTrack != NULL) {		foreach ($defaultTrack as $_record) {			$id = $_record['id'];			$title = $_record['title'];			$private = (isset($_record['private']) && $_record['private'] == 1) ? 'private' : '';			$trackString .= '<option value="' . $id . '" class="' . $private . '">' . $title . '</option>';		}	}	foreach ($_SESSION['_myTracks'] as $_record) {		$id = $_record['id'];		$title = $_record['title'];		$private = (isset($_record['private']) && $_record['private'] == 1) ? 'private' : '';		$trackString .= '<option value="' . $id . '" class="' . $private . '">' . $title . '</option>';	}	$trackString .= '</select>';}?><!DOCTYPE html><html>	<head>		<title>Tackster | Bookmark</title>		<meta name="viewport" content="width=device-width, initial-scale=1.0">		<meta name="description" content="">		<meta name="author" content="">		<!-- Bootstrap -->		<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">		<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">		<!-- Style Sheets -->		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.min.css" rel="stylesheet"> <!--for delete and edit icons-->		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->		<!--[if lt IE 9]>		<script src="/framework/bootstrap/assets/js/html5shiv.js"></script>		<script src="/framework/bootstrap/assets/js/respond.min.js"></script>		<![endif]-->		<!-- JavaScript -->		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>		<!-- Include all compiled plugins (below), or include individual files as needed -->		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>		<script type="text/javascript">			function getDescription(url){				if(url.indexOf("http://") == -1 && url != "http://")				{					url = "http://" + url;					document.getElementById("url").value = url;				}				if((url.slice(-3)!= "com") && (url.slice(-3)!= "net")					&& (url.slice(-3)!= "gov") && (url.slice(-3)!= "org")					&& (url.slice(-3)!= "edu"))				{					document.getElementById("createBookmark").description.disabled = true;					//document.getElementById("createBookmark").description.value ="";					document.getElementById("createBookmark").keywords.disabled = true;					document.getElementById("createBookmark").privacy.disabled =true;					document.getElementById("createBookmark").tid.disabled = true;					//getImages(null);					// return;				}else{					document.getElementById("createBookmark").description.disabled = false;					//document.getElementById("createBookmark").description.value ="";					document.getElementById("createBookmark").keywords.disabled = false;					document.getElementById("createBookmark").privacy.disabled =false;					document.getElementById("createBookmark").tid.disabled = false;					getImages(url);				}			}			function getImages(url){				var xmlhttp;				if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari					xmlhttp=new XMLHttpRequest();				} else { // code for IE6, IE5					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");				}				xmlhttp.onreadystatechange=function() {					if (xmlhttp.readyState==4 && xmlhttp.status==200) {						document.getElementById("sitePictures").style.visibility = "visible";						document.getElementById("sitePictures").innerHTML=xmlhttp.responseText;					}				}				xmlhttp.open("GET",'/bookmark/getURLpic.php?url='+url,true);				xmlhttp.send();			}			function setImage(src){				if(src != null)				{					document.getElementById("timage").src = src;					document.getElementById("sitePictures").style.visibility = "hidden";					document.getElementById("sitePictures").style.height = "0px";					document.getElementById("imageSrc").value = src;					document.getElementById("selectImgBtn").innerHTML = "Select a new Image"				}			}			function displayImages(){				var url = document.getElementById("url").value;				getImages(url);				document.getElementById("sitePictures").style.visibility = "visible";				document.getElementById("sitePictures").style.height = "300px";			}		</script>		<script>			$(function() {				$( document ).tooltip({					track: true				});			});		</script>	</head>	<body>		<script>			$('#submit_id').click($.colorbox.close());		</script>		<!-- Body Content-->		<div class="bookmark">			<h3> Update Bookmark</h3>			<div class="container">				<div class="well">					<?php					if (count($_websiteErr) > 0 || $_websiteErr != NULL) {						echo $_websiteErr;					}					?>                    <form class="form-horizontal" id="createBookmark" name="createBookmark" method="post" action="editBookmark.php">                        <input id="formFlag" type="hidden" name="formFlag" value="TRUE">                        <input id="bid" type="hidden" name="bid" value="<?php echo_formData($bookmarkId); ?>">						<table>							<tr>								<td><label>URL: </label></td>								<td><input id="url" type="text" maxlength="255" name="url" value="<?php echo_formData($url); ?>" onKeyUp="getDescription(url.value);" required placeholder="http://www.somesite.com"></td>							</tr>							<tr>								<td><label style="padding-top:5px;">Description:</label></td>								<td><textarea name="description" rows="3" required><?php echo_formData($description); ?></textarea></td>							</tr>							<tr>								<td><label style="padding-top:5px;">Keywords: </label></td>								<td><input id="keywords" type="text" name="keyword" value="<?php echo_formData($keyword); ?>" placeholder="Comma Seperated List" required></td>							</tr>							<tr>								<td><label style="padding-top:5px;">Add to Track: </label></td>								<td>									<?php echo_formData($trackString); ?>								</td>							</tr>							<tr>								<td><label style="padding-top:5px;">Privacy: </label></td>								<td>									<select name="privacy" id="privacy" required>										<option value="0" <?php if ($privacy == 0) echo "selected"; ?>>Share</option>										<option value="1" <?php if ($privacy == 1) echo "selected"; ?>>For Me</option>									</select>								</td>							</tr>							<tr>								<td><label>Thumbnail: </label></td>								<td><input id="imageSrc" type="hidden" name="imageSrc" value="<?php if ($imageSrc != null) echo echo_formData($imageSrc); else echo "/shared/images/placeholder.jpg"; ?>">									<img id="timage" style="max-height: 150px; max-width: 200px;" class="img-polaroid" src="<?php if ($imageSrc != null) echo echo_formData($imageSrc); else echo "/shared/images/placeholder.jpg"; ?>">									<div style="display: compact; float:right; max-width: 150px;"><button id="selectImgBtn" class="btn btn-success btn-block" type="button" onclick="displayImages()">Select a new image</button></div>									<div style="max-height:200px; overflow: auto; visibility: hidden;"id="sitePictures" >										<h4>Please enter the URL first.</h4>									</div> <!--- /site pictures -->								</td>							</tr>						</table>						<button class="btn btn-success" type="submit" id="submit_id">Submit</button>					</form>                    <button style="position: relative; top: -27px;"class="btn btn-danger" onclick="location.href='/bookmark/?bid=<?php echo_formData($bookmarkId); ?>'">Cancel</button>				</div>			</div>		</div>		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />		<script>			//Script to handle autocomplete for keywords with CSVs			$(document).ready(function($){				$('#keywords').autocomplete({source:function (request, response) {						$.getJSON("../search/autocomplete.php", {							term: extractLast(request.term)						}, response);					},					//Jquery events to handle					search: function () {						var term = extractLast(this.value);						// Set length you want autocomplete to start searching at						if (term.length < 1) {							return false;						}					},					focus: function () {						// prevent value inserted on focus						return false;					},					appendTo: $("#keywords").next(),					select: function (event, ui) {						var terms = split(this.value);						// remove the current input						terms.pop();						// add the selected item						terms.push(ui.item.value);						// add placeholder to get the comma-and-space at the end						terms.push("");						this.value = terms.join(", ");						return false;					}, minLength:1});			});			function split(val) {				return val.split(/,\s*/);			}			function extractLast(term) {				return split(term).pop();			}		</script>		<!-- /Body Content-->	</body></html>