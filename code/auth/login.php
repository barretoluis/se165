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
$_websiteErr = Array(); //Error message to show end user
//If you're already logged in, redirect to the dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
	header('Location: /dashboard/');
}

//test if user is trying to login, if so, do a credential test
if (isset($_POST['username']) || isset($_POST['password'])) {
	if ($_POST['username'] == NULL) {
		array_push($_websiteErr, 'Please complete the username field.');
	} elseif ($_POST['password'] == NULL) {
		array_push($_websiteErr, 'Please complete the password field.');
	} else {
		//Looks like someone is trying to login
		try {
			$userObj = new User();
			$username = $_POST['username'];
			$password = $_POST['password'];
			$userObj->logInUser($username, $password);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			array_push($_websiteErr, 'User / Password combination did not work.');
		}
	}
}

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
		<title>Tackster | Login</title>
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

		<link rel="stylesheet" type="text/css" href="/shared/css/loginStyle.css" />
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
					<a class="brand" href="/" style="color: #00B800">Tackster</a>
					<div class="nav-collapse collapse">
						<p class="navbar-text pull-right">
							<a class="btn btn-success" href="/auth/register.php" role = "button" style=" margin: 0 -10px 0px 0">Sign Up</a>
						</p>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<!-- /Navigation Bar -->

		<!-- LOGIN FORM  -->
		<div class="container" style="margin-top: 80px;">
			<section id="content">
				<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" name="formLogin" id="formLogin">
					<h1>Login</h1>
					<?php echo_formData($errString); ?>
					<div>
						<input type="text" name="username" id="username" maxlength="40" placeholder="Username">
					</div>
					<div>
						<input type="password" name="password" id="password" maxlength="15" placeholder="Password">
					</div>
					<div>
						<a href="forgotPassword.php">Forgot Password?</a>
					</div>
					<div>
						<button class="btn btn-default" type="submit">Login</button>
					</div>
				</form><!-- form -->
				<h6><span  class="line-center">OR</span></h6>
				<a href="#" onClick="MyWindow=window.open('https://www.facebook.com/login.php?skip_api_login=1&api_key=294846713986884&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Foauth%3Fredirect_uri%3Dhttp%253A%252F%252F153.18.33.144%252FDEV%252F%26state%3D7a56d86c0a6c372440bf849d630e2a27%26scope%3Demail%26client_id%3D294846713986884%26ret%3Dlogin&cancel_uri=http%3A%2F%2F153.18.33.144%2FDEV%2F%3Ferror%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied%26state%3D7a56d86c0a6c372440bf849d630e2a27%23_%3D_&display=page','MyWindow',width=20,height=30); return false;">
					<img src= "http://i.imgur.com/zIhhdJP.png" alt="Login with Facebook" class= "img-rounded" style="margin-top: 10px"/>
				</a>
			</section><!-- content -->
		</div><!-- container -->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->
	</body>
</html>
