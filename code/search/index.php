<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
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
$htmlHeadTitle = (isset($htmlHeadTitle)) ? $htmlHeadTitle : "Search Results";
//check if errors already set in headerSearch.php
$_websiteErr = (isset($_websiteErr)) ? $_websiteErr: Array(); //Error message to show end user

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
		<title>Tackster | Search Result</title>
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

		<link href="/shared/css/bookmarkStyle.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/shared/js/modernizr.custom.69142.js"></script>

		<!-- Popups and onClick-->
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
		<link href="/shared/css/colorbox.css" rel="stylesheet">
		<script src="/framework/jquery/jquery.colorbox.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".bmkUrl").colorbox({iframe:true, width:"50%", height:"85%", href:$(this).attr("href")});
//				return false;
			});
		</script>

	</head>


	<body>
		<!-- Navigation Bar -->
		<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->


		<!-- Body Content-->
		<div id="bookmarks" class="main" >
			<h3><?php echo_formData($htmlHeadTitle) ?></h3>

			<?php
			if (count($_websiteErr) > 0 || $_websiteErr != NULL) {
				echo $_websiteErr;
			}
			?>

			<?php
			if ($formSubmitted == TRUE && isset($_bookmarks) == TRUE && count($_bookmarks) >= 1) {
				foreach ($_bookmarks as $_bmk) {
					$_bmk['comment_count'] = 0; //TODO: Build code for showing bookmarks likes
					$_bmk['like_count'] = 0; //TODO: Build code for showing bookmarks likes
					$_bmk['repin_count'] = 0; //TODO: Build code for showing bookmarks likes
					$html = '<div class="view" id="view">\n';
					$html .= '	<div class="view-back">\n';
					$html .= '		<span data-icon="b">' . $_bmk['comment_count'] . '</span>\n';
					$html .= '		<span data-icon="h">' . $_bmk['like_count'] . '</span>\n';  //TODO: Repin count needed
					$html .= '		<span data-icon="B">' . $_bmk['repin_count'] . '</span>\n';   //TODO: What is this for?
					$html .= '		<a class="bmkUrl" id="bmkUrl" href="/bookmark/?bid=' . $_bmk['id'] . '" bid="' . $_bmk['id'] . '">&rarr;</a>\n';
					$html .= '	</div>';
					$html .= '	<img src="/shared/images/4.jpg" />\n';  //TODO: Pull reference from DB
					$html .= '</div>\n\n';

					echo_formData($html);
					flush();
				}
			} elseif ($formSubmitted == TRUE) {
				print("<p class='noSearchResults'>No search results were found.</p>");
			}
			?>
		</div>

		<!-- /Body Content-->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->

	</body>
</html>