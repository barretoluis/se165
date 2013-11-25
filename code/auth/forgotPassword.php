<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
	'FacebookConnector/FacebookConnector.class.php'
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
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.

$_websiteErr = Array();
$_websiteSuc = Array();
$actionType = NULL;
$resetEmail = NULL;
$resetPass = NULL;
$resetPassConf = NULL;
$resetToken = NULL;
$User = new User();

// let's see what the user is trying to do
if (isset($_POST['username'])) {
//form was submitted to reset the password
	$actionType = 'tokenSend';
	$resetEmail = $_POST['username'];
} elseif (isset($_GET['e']) && $_GET['t']) {
//clicked on email link to reset the password
	$actionType = 'tokenRecvd';
	$resetEmail = urldecode($_GET['e']);
	$resetToken = urldecode($_GET['t']);
} elseif (isset($_POST['password']) && isset($_POST['passwordConf'])) {
	$actionType = 'setPassword';
	$resetPass = $_POST['password'];
	$resetPassConf = $_POST['passwordConf'];
}


if ($actionType == 'tokenSend') {
//user wants to request a password reset
	try {
		if ($User->resetPassGenToken($resetEmail)) {
			$actionType = 'tokenSendSuccess';
		}
	} catch (MyException $e) {
		array_push($_websiteErr, $e->getMessage());
		$e->getMyExceptionMessage();
	}
}


//if ($actionType == 'tokenRecvd') {
////user wants to request a password reset
//	try {
//		if ($User->resetPassword($resetEmail, $newPWD)) {
//			$actionType = 'tokenRecvdSuccess';
//		}
//	} catch (MyException $e) {
//		array_push($_websiteErr, $e->getMessage());
//		$e->getMyExceptionMessage();
//	}
//}


if ($actionType == 'setPassword') {
//user wants to request a password reset
//basic password validation
	if ($resetPass != $resetPassConf) {
		array_push($_websiteErr, 'The passwords do not match. Please try again.');
		$resetPassConf = NULL;
	}

	//let's reset the password
	try {

		$actionType = 'setPasswordSuccess';
		array_push($_websiteSuc, 'Password reset successful. Please <a href="/auth/login.php">login here</a>.');
	} catch (MyException $e) {
		array_push($_websiteErr, $e->getMessage());
		$e->getMyExceptionMessage();
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

		<link rel="stylesheet" type="text/css" href="/shared/css/forgotPassStyle.css" />
	</head>

	<body>

		<!-- Navigation Bar -->
		<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->

		<!-- LOGIN FORM  -->
		<div class="container" style="margin-top: 80px;">
			<section id="content">
				<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" name="formLogin" id="formLogin">
					<input type="hidden" name="token" value="<?php echo_formData($resetToken); ?>">
					<input type="hidden" name="email" value="<?php echo_formData($resetEmail); ?>">
					<h1>Forgot Password</h1>
					<?php
					if (count($_websiteErr) > 0 || $_websiteErr != NULL) {
						echo $_websiteErr;
					}
					?>
					<?php if ($actionType == 'tokenSendSuccess') { ?>
						<div>
							<p>Form submission received. Please expect an email shortly for completing the password reset process.</p>
						</div>
					<?php } elseif($actionType == 'setPasswordSuccess') { ?>
						<div>
							<p>Password successfully reset. <a href="/auth/login.php">Please login here.</a></p>
						</div>
					<?php } ?>

					<?php if ($actionType == NULL || $actionType == 'tokenSend') { ?>
						<div>
							<input type="text" name="username" id="username" maxlength="40" placeholder="email" value="<?php echo_formData($resetEmail); ?>" autofocus="">
						</div>
						<div>
							<button class="btn btn-default" type="submit">Submit</button>
						</div>
					<?php } ?>

					<?php if ($actionType == 'tokenRecvd' || ($actionType == 'setPassword' && count($_websiteErr) > 0)) { ?>
						<div>
							<input type="password" name="password" id="password" maxlength="40" placeholder="New Password" autofocus="">
						</div>
						<div>
							<input type="password" name="passwordConf" id="password" maxlength="40" placeholder="Confirm Password">
						</div>
						<div>
							<button class="btn btn-default" type="submit">Submit</button>
						</div>
					<?php } ?>
				</form><!-- form -->
				<p><br></p>
			</section><!-- content -->
		</div><!-- container -->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->
	</body>
</html>
