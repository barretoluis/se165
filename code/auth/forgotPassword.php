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

?><!DOCTYPE html>
<!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Forgot Password</title>
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

		<!-- Navigation Bar - DON'T use navbar.php as this navigation bar is specific to login.php alone -->
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="/" class="brand"><img src="/shared/images/logo_tackster.png" style="margin: -9px 0px -9px 0px;"></a>
					<div class="nav-collapse collapse">
						<p class="navbar-text pull-right">
							<a class="btn btn-success" href="/auth/register.php" role = "button" style=" margin: 0 -10px 0px 0">Sign Up</a>
						</p>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<!-- /Navigation Bar -->

                <!-- Body Content-->
                <div class="forgotPassword">
                    <h3>Forgot Password</h3>
                    <div class="container">
                        <div class="well">
                            <table>
                                 <tr>
                                    <td>Enter Email:</td> <!-- Should they be allowed to change their email address?-->
                                    <td>&nbsp;&nbsp;<input type = "email" name = "email" id = "email"/></td>
                                 </tr>

                             </table>
                             <p><button class="btn btn-success" type="submit" on-click="">Submit</button></p>
                             <br/>
                        </div>
                    </div>
		</div>
		<!-- /Body Content-->

                <!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->
	</body>
</html>
