<?php/* * Add additional include files to array if needed for this page. */$includeFilesAdditional = array(	'Bookmark/Bookmark.class.php');// DO NOT EDIT THIS BLOCK - START/* * Require mandatory libraries to be loaded. * Else, redirect to server outage page. * */try {	// require the primary include file	if (!include_once('main.php')) {		throw new Exception("Unable to include the main library.\n");	}} catch (Exception $e) {	throw new Exception('Was not able to include the main.php file.', 0, $e);	header('HTTP/1.1 500 Internal Server Error', true, 500);	exit(0);}// DO NOT EDIT THIS BLOCK - END/* * Page specific PHP code here */$bookmarkObj = NULL;$websiteErr = NULL;?><!DOCTYPE html><html>	<head>		<title>Tackster | Bookmark</title>		<meta name="viewport" content="width=device-width, initial-scale=1.0">		<meta name="description" content="">		<meta name="author" content="">		<!-- Bootstrap -->		<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">		<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">		<!-- Style Sheets -->		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->		<!--[if lt IE 9]>		<script src="/framework/bootstrap/assets/js/html5shiv.js"></script>		<script src="/framework/bootstrap/assets/js/respond.min.js"></script>		<![endif]-->		<!-- JavaScript -->		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>		<!-- Include all compiled plugins (below), or include individual files as needed -->		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>		<script type="text/javascript">			function getDescription(url){				var xmlhttp;				if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari					xmlhttp=new XMLHttpRequest();				} else {// code for IE6, IE5					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");				}				xmlhttp.onreadystatechange=function() {					if (xmlhttp.readyState==4 && xmlhttp.status==200) {						//document.getElementById("myDiv").innerHTML=xmlhttp.responseText;						document.getElementById("createBookmark").description.value=xmlhttp.responseText;					}				}				xmlhttp.open("GET",'getURLdes.php?url='+url,true);				xmlhttp.send();			}			function getImages(url){				var xmlhttp;				if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari					xmlhttp=new XMLHttpRequest();				} else { // code for IE6, IE5					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");				}				xmlhttp.onreadystatechange=function() {					if (xmlhttp.readyState==4 && xmlhttp.status==200) {						document.getElementById("myDiv").innerHTML=xmlhttp.responseText;					}				}				xmlhttp.open("GET",'getURLpic.php?url='+url,true);				xmlhttp.send();			}		</script>	</head>	<body>		<!-- Navigation Bar -->		<?php require_once('html/navbar.php'); ?>		<!-- /Navigation Bar -->		<!-- Body Content-->		<div class="bookmark">                    <h3>Add Bookmark</h3>                    <div class="container">                        <div class="well">                            <form class="form-horizontal" id="createBookmark" name="createBookmark" method="post" Xaction="createBookmark.php">                                <table>                                    <tr>                                        <td><label>URL: </label></td>                                        <td><input id="url" type="text" name="url" value="http://" onKeyUp="getDescription(url.value); getImages(url.value);" required ></td>                                    </tr>                                    <tr>                                        <td><label style="padding-top:5px;">Description:</label></td>                                        <td><textarea name="description" rows="3"></textarea></td>                                    </tr>                                    <tr>                                        <td><label style="padding-top:5px;">Keywords: </label></td>                                        <td><input type="text" name="keywords"><span class="error"><?php echo $websiteErr;?></span></td>                                    </tr>                                </table>				<button class="btn btn-success" type="submit" >Submit</button>                            </form>			</div>                    </div>                </div>			<!-- /Body Content-->			<!-- Footer Content -->		<?php require_once('html/footer.php'); ?>			<!-- /Footer Content -->	</body></html>