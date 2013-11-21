<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
	'FacebookConnector/FacebookConnector.class.php',
	'Auth/User.class.php'
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
$htmlFb = NULL;
$FBConn = new FacebookConnector();
try {
	$fb_userInfo = $FBConn->getUserInfo();
} catch (MyException $e) {
	$fb_userInfo = NULL;
	$e->getMyExceptionMessage();
}

//if we have no FB user info, they haven't logged in
//redirect to login screen
if ($fb_userInfo == NULL) {
	header('Location: /auth/login.php');
}


//let's define all the variables we'll need to create a profile if needed
try {
	$fb_email = $fb_userInfo['email'];
	$fb_first = $fb_userInfo['first_name'];
	$fb_last = $fb_userInfo['last_name'];
	$fb_username = $fb_userInfo['username'];
	$fb_gender = $fb_userInfo['gender'];

	$userDataArray = Array(
		"fname" => "{$fb_first}",
		"lname" => "{$fb_last}",
		"email" => "{$fb_email}",
		"password" => "{$fb_email}_facebookLogin",
		"gender" => "{$fb_gender}",
		"source" => "F"
	);
} catch (MyException $e) {
	$e->getMyExceptionMessage();
}


//check if email already in system else create a new account
$User = new User();
try {
	if (!$User->loadUser($fb_email)) {
		//create user because the email isn't in our system
		$userCreateStatus = $User->createUser($userDataArray);
		if (!$userCreateStatus) {
			array_push($_websiteErr, 'Was not able to create your Tackster profile. We recommend you <a href="/auth/register.php">create a profile manually here</a>.');
		}
	}
} catch (MyException $e) {
	array_push($_websiteErr, 'We seem to have some system issues. Please try again shortly.');
	$e->getMyExceptionMessage();
}

//time to load the user info
try {
	$User->logInFbUser($fb_email);
} catch (MyException $e) {
	$fb_userInfo = NULL;
	session_destroy();
	session_start();
	array_push($_websiteErr, $e->getMessage());
	$_SESSION['_websiteErr'] = $_websiteErr;
	$e->getMyExceptionMessage();
}

//$htmlFb =  ">>" . $FBUserFound;
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
		<title>Tackster | Login Via Facebook</title>
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

		<?php
		if (count($_websiteErr) >= 1) {
			?>
			<script type="text/javascript">
				window.opener.document.location.href = '/auth/login.php';
				window.close();
			</script>

			<?php
		} else {
			?>
			<script type="text/javascript">
				window.opener.location.reload();
				window.close();
			</script>
			<?php
		}
		?>
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
		<div class="main">
			<?php
			if (count($_websiteErr) > 0 || $_websiteErr != NULL) {
				echo $_websiteErr;
			}
			?>

			<pre><?php var_dump($_SESSION) ?></pre>
		</div><!-- container -->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->
	</body>
</html>
