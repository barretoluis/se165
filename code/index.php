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
		<meta charset="utf-8">
		<title>Home2</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="">

		<!-- styles -->
		<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- Style Sheets -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">
		<link href="/shared/css/home.css" rel="stylesheet" type="text/css">

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
		<?php require_once('html/navbarHome.php'); ?>
		<!-- /Navigation Bar -->

		<!-- Body Content-->
        <div id="site-container" class="context-loader-container" data-pjax-container="">
			<div class="marketing-section marketing-section-signup">
				<div class="container">
					<form accept-charset="UTF-8" autocomplete="off" class="form-signup-home js-form-signup-home" method="post">
						<dl class="form">
							<dd>
								<input type="text" name="loginName" class="textfield" required="" placeholder="Name"autofocus="">
							</dd>
						</dl>
						<dl class="form">
							<dd>
								<input type="text" name="loginEmail" class="textfield" required="" placeholder="Email">
							</dd>
						</dl>
						<dl class="form">
							<dd>
								<input type="password" name="loginPassword" class="textfield" required="" placeholder="Password">
							</dd>
						</dl>
						<dl class="form">
							<dd>
								<button class="btn btn-success" type="submit" >Sign up</button>
							</dd>
						</dl>
					</form>
					<h1 class="heading">Explore, and Share your Interests</h1>
					<p class="subheading">Easier and a faster way to pin your brain...</p>
				</div><!-- /.container -->
			</div>
			<!-- /Body Content-->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->

	</body>
</html>