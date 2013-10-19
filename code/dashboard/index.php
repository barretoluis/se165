<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
	'Bookmark/SearchBookmark.class.php'
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
$searchWord = NULL; //search terms from form
$_bookmarks = NULL; //return results of found bookmarks as an array
$formError = NULL; //form error messages to show end user on web page
$formSubmitted = FALSE; //flag if form was submitted
//TODO: Right now I'm doing a hard search. Need to fix based on track.

//prefer a post variable over a get
$searchWord = 'search';

//Do a search for the search words
if (strlen($searchWord) >= 0) { //was a keyword even submitted
	try {
		$getBookmark = new SearchBookmark();
		$_bookmarks = $getBookmark->getBookmark($searchWord);
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}
} else {
	$formError = "No search terms were provided in the Bookmark Search.";
}
$formSubmitted = TRUE;
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | My Dashboard</title>
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

		<link href="/shared/css/tackStyle.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/shared/js/modernizr.custom.69142.js"></script>

		<script type="text/javascript">
			//TODO: The font heydings is being called. Where is it in the code... probably remove it.
                        //Reply (Shruti): can't remove it b/c those give the icons: heart, bookmark, comments on the each track!
			Modernizr.load({
				test: Modernizr.csstransforms3d && Modernizr.csstransitions,
				yep : ['http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js','/shared/js/jquery.hoverfold.js'],
				nope: 'css/fallback.css',
				callback : function( url, result, key ) {
					if( url === '/shared/js/jquery.hoverfold.js' ) {
						$( '#bookmarks' ).hoverfold();
					}
				}
			});
		</script>

	</head>


	<body>
		<!-- Navigation Bar -->
<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->


		<!-- Body Content-->
		<div id="bookmarks" class="main" >
			<h3>My Dashboard</h3>
			<?php if ($formError) { ?>
				<div class="formError"><h4>Form Error</h4><?php echo $formError ?></div>
			<?php } ?>

			<p><?php
			if (isset($_bookmarks)) {
				foreach ($_bookmarks as $_bmk) {
					$html = '<div class="view">';
					$html .= '	<div class="view-back">';
					$html .= '		<span data-icon="b">' . $_bmk['like_count'] . '</span>';
					$html .= '		<span data-icon="h">???</span>';  //TODO: Repin count needed
					$html .= '		<span data-icon="B">???</span>';   //TODO: What is this for?
					$html .= '		<a href="' . $_bmk['url'] . '">&rarr;</a>';
					$html .= '	</div>';
					$html .= '	<img src="/shared/images/4.jpg" />';  //TODO: Pull reference from DB
					$html .= '</div>';

					echo_formData($html);
				}
			} else {
				print("<p class='noSearchResults'>You currently have no bookmarks in this Track.</p>");
			}
			?></p>

		</div>

		<!-- /Body Content-->

		<!-- Footer Content -->
<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->

	</body>
</html>