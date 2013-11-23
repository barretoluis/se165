<?php/* * Add additional include files to array if needed for this page. */$includeFilesAdditional = array(	'Bookmark/Bookmark.class.php');// DO NOT EDIT THIS BLOCK - START/* * Require mandatory libraries to be loaded. * Else, redirect to server outage page. * */try {	// require the primary include file	if (!include_once('main.php')) {		throw new Exception("Unable to include the main library.\n");	}} catch (Exception $e) {	throw new Exception('Was not able to include the main.php file.', 0, $e);	header('HTTP/1.1 500 Internal Server Error', true, 500);	exit(0);}// DO NOT EDIT THIS BLOCK - END/* * Page specific PHP code here */$_websiteErr = Array();$_followingTracks = Array();$trackId = (isset($_POST['tid'])) ? (int) $_POST['tid'] : NULL;$url = (isset($_POST['url'])) ? $_POST['url'] : NULL;$privacy = (isset($_POST['privacy'])) ? (int) $_POST['privacy'] : NULL;$description = (isset($_POST['description'])) ? $_POST['description'] : NULL;$keyword = (isset($_POST['keyword'])) ? $_POST['keyword'] : NULL;if (isset($_POST['tid'])) {	try {		$Bookmark = new Bookmark();		$friendlyErrors = $Bookmark->createBookmark($trackId, $url, $privacy, $description, $keyword);		array_push($_websiteErr, $friendlyErrors);	} catch (MyException $e) {//		$e->getMyExceptionMessage();		array_push($_websiteErr, $e->getMessage());	}	if (count($_websiteErr) >= 1) {		$errString = '<div class="formError"><p><b>We encountered the following issue with your request:</b></p><ol>';		foreach ($_websiteErr as $value) {			$errString .= "<li>" . $value . "</li>\n";		}		$errString .= '</ol></div>';		$_websiteErr = $errString;	} else {		include 'html/formSuccess.php';		exit;	}}//Get user's tracks if not available in session alreadyif (!isset($_SESSION['_myTracks']) || !isset($_SESSION['_followingTracks'])) {	try {		$myTracks = new track();		$_myTracks = $myTracks->getMyTrack($_SESSION['uc_id'], 'id,title');		$_followingTracks = $myTracks->returnFollowingTracks($_SESSION['uc_id'], 'id,title,private');		$_SESSION['_myTracks'] = $_myTracks;		$_SESSION['_followingTracks'] = $_followingTracks;	} catch (MyException $e) {		$e->getMyExceptionMessage();	}}//Let's populate the search bar with the user's tracksif (isset($_SESSION['_myTracks'])) {	$trackString = '<select name="tid" id="tid">';	$trackString .= '<option value="-1" class="">Select Track</option>';	foreach ($_SESSION['_myTracks'] as $_record) {		$id = $_record['id'];		$title = $_record['title'];		$private = (isset($_record['private']) && $_record['private'] == 1) ? 'private' : '';		$trackString .= '<option value="' . $id . '" class="' . $private . '">' . $title . '</option>';	}	$trackString .= '</select>';}?><!DOCTYPE html><html>	<head>		<title>Tackster | Bookmark</title>		<meta name="viewport" content="width=device-width, initial-scale=1.0">		<meta name="description" content="">		<meta name="author" content="">		<!-- Bootstrap -->		<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">		<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">		<!-- Style Sheets -->		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>                <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.2/css/font-awesome.min.css" rel="stylesheet"> <!--for delete and edit icons-->		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->		<!--[if lt IE 9]>		<script src="/framework/bootstrap/assets/js/html5shiv.js"></script>		<script src="/framework/bootstrap/assets/js/respond.min.js"></script>		<![endif]-->		<!-- JavaScript -->		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>		<!-- Include all compiled plugins (below), or include individual files as needed -->		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>		<script type="text/javascript">			function getDescription(url){				if(url.indexOf("http://") == -1)				{					url = "http://" + url;				}				var xmlhttp;				if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari					xmlhttp=new XMLHttpRequest();				} else {// code for IE6, IE5					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");				}				xmlhttp.onreadystatechange=function() {					if (xmlhttp.readyState==4 && xmlhttp.status==200) {						//document.getElementById("myDiv").innerHTML=xmlhttp.responseText;						document.getElementById("createBookmark").description.value=xmlhttp.responseText;					}				}				xmlhttp.open("GET",'getURLdes.php?url='+url,true);				xmlhttp.send();			}			function getImages(url){				if(url.indexOf("http://") == -1)				{					url = "http://" + url;				}				var xmlhttp;				if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari					xmlhttp=new XMLHttpRequest();				} else { // code for IE6, IE5					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");				}				xmlhttp.onreadystatechange=function() {					if (xmlhttp.readyState==4 && xmlhttp.status==200) {						document.getElementById("sitePictures").style.visibility = "visible";						document.getElementById("sitePictures").innerHTML=xmlhttp.responseText;					}				}				xmlhttp.open("GET",'getURLpic.php?url='+url,true);				xmlhttp.send();			}			function setImage(src){				if(src != null)				{					document.getElementById("timage").src = src;					document.getElementById("sitePictures").style.visibility = "hidden";				}			}			function displayImages(){				document.getElementById("sitePictures").style.visibility = "visible";			}		</script>                <script>                    $(function() {                      $( document ).tooltip({                        track: true                      });                    });                </script>	</head>	<body>		<script>			$('#submit_id').click($.colorbox.close());		</script>		<!-- Body Content-->		<div class="bookmark">			<h3>Add Bookmark</h3>			<div class="container">				<div class="well">					<?php					if (count($_websiteErr) > 0 || $_websiteErr != NULL) {						echo $_websiteErr;					}					?>					<form class="form-horizontal" id="createBookmark" name="createBookmark" method="post" action="createBookmark.php">                                            <div id ="icons" >                                                <ul>                                                <li><a href="#" title="Delete Bookmark"><i class="fa fa-trash-o fa-lg"></i></a></li>                                                <li><a href="#" title="Edit Bookmark"><i class="fa fa-pencil fa-lg"></i></a></li>                                                <li><a href="#" title="Website"><i class="fa fa-external-link fa-lg"></i></a></li>                                                <li><a href="#" title="Like Bookmark"><i class="fa fa-heart fa-lg"></i></a></li>                                                </ul>                                              </div>                                            <table>							<tr>								<td><label>URL: </label></td>								<td><input id="url" type="text" name="url" value="<?php echo_formData($url); ?>" onKeyUp="getDescription(url.value); getImages(url.value);" required placeholder="http://www.somesite.com"></td>							</tr>							<tr>								<td><label style="padding-top:5px;">Description:</label></td>								<td><textarea name="description" rows="3"><?php echo_formData($description); ?></textarea></td>							</tr>							<tr>								<td><label style="padding-top:5px;">Keywords: </label></td>								<td><input type="text" name="keyword" value="<?php echo_formData($keyword); ?>" placeholder="Comma Seperated List"></td>							</tr>							<tr>								<td><label style="padding-top:5px;">Add to Track: </label></td>								<td>									<?php echo_formData($trackString); ?>								</td>							</tr>							<tr>								<td><label style="padding-top:5px;">Privacy: </label></td>								<td>									<select name="privacy" id="privacy">										<option value="0">Share</option>										<option value="1">For Me</option>									</select>								</td>							</tr>							<tr>								<td><label>Thumbnail: </label></td>								<td><img id="timage" style="max-height: 150px; max-width: 200px;" class="img-polaroid" src="/shared/images/placeholder.jpg">									<div style="display: compact; float:right; max-width: 150px;"><button class="btn btn-success btn-block" type="button" onclick="displayImages()">Select an Image</button></div>									<div style="max-height:200px; overflow: auto; visibility: hidden;"id="sitePictures" >                                        <h4>Please enter the URL first.</h4>                                    </div> <!--- /site pictures -->								</td>							</tr>						</table>						<button class="btn btn-success" type="submit" id="submit_id">Submit</button>					</form>				</div>			</div>		</div>		<!-- /Body Content-->	</body></html>