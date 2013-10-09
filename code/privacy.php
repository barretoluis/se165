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


?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Privacy</title>
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
		<div id="privacy" class="main" >
			<h3>Privacy</h3>

			<p>Donec id tellus vel nunc condimentum vulputate a in sem. Donec et nisi suscipit, dignissim sapien id, varius turpis. Donec sagittis egestas sem rhoncus cursus. Duis consequat ligula vel sem vestibulum, in facilisis elit tincidunt. Ut scelerisque dapibus ipsum, a molestie lacus varius vitae. Praesent pulvinar id dui ac consectetur. Etiam dignissim posuere mi ut vulputate. Maecenas auctor nibh vitae tellus tempor, nec ultrices lectus porttitor. Phasellus dolor libero, dignissim eget tempor et, interdum vitae ligula.</p>

			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam in lacus ligula. Donec consectetur tortor id felis ultricies mattis. Etiam ipsum nulla, sagittis et sollicitudin vitae, fermentum nec sem. Aliquam erat volutpat. Ut dui erat, suscipit eget ultrices non, tristique ac lectus. Etiam laoreet, est et elementum porttitor, felis lorem elementum diam, sed fringilla tortor augue vitae ante. Duis tincidunt nunc tellus, nec convallis nisi egestas a. Ut gravida, velit a semper dignissim, sem leo tempus tellus, quis blandit tellus massa vitae lectus. Maecenas quam sapien, lobortis nec dictum vitae, ultrices id magna. Pellentesque at nunc et odio egestas blandit vitae at elit. Vivamus egestas scelerisque vehicula. Etiam elementum, sapien quis sollicitudin ullamcorper, justo nunc dignissim urna, eu tempus ligula orci vitae enim. In hac habitasse platea dictumst. Ut et odio nec elit ornare posuere in eu lacus.</p>

			<p>Nulla volutpat erat eget urna mattis, ac vehicula ligula luctus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut sed enim quis mi blandit vestibulum eu quis magna. Morbi blandit feugiat neque vitae vulputate. Maecenas eleifend pretium nunc dictum gravida. Nam feugiat sit amet augue eu auctor. Nullam vulputate nisl lacus, quis tincidunt eros semper nec.</p>
		</div>
		<!-- /Body Content-->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->

	</body>
</html>