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
		<title>Tackster | My Profile</title>
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
		<?php //require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->


		<!-- Body Content-->
		<div id="trackCreate" class="main" >
			<div class="jumbotron">
				<div class="container">
					<h3>Create Track</h3>

					<form class="form-horizontal" role="form" method="POST" action="/track/addTrack.php">
						<div class="form-group">
							<label for="inputName" class="col-sm-2 control-label">Name</label>
							<div class="col-md-3">
								<input type="text" name="name" class="form-control" id="inputEmail1" placeholder="Track name">
							</div>
						</div>
						<div class="form-group">
							<label for="inputDesc" class="col-md-2 control-label col">Description</label>
							<div class="col-md-3">
								<textarea name ="desc" class="span3" cols="50" id="inputdesc" placeholder="Description" rows="5"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPrivacy" class="col-md-2 control-label col">Privacy</label>
							<div class="col-md-3">
								<select name="privacy" id="inputPrivacy">
									<option value="F">Public</option>
									<option value="T">Private</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-offset-2 col-md-10">
								<button type="submit" class="btn btn-success">Create</button>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>

		<!-- /Body Content-->

		<!-- Footer Content -->
		<?php //require_once('html/footer.php'); ?>
		<!-- /Footer Content -->

	</body>
</html>
