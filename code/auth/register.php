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
 * Checking if the form is submitted
 */

$_websiteErr = Array(); //Error message to show end user
//If you're already logged in, redirect to the dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
	header('Location: /dashboard/');
}

//create a user
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['fname']) && isset($_POST['lname'])) {
	try {
		$userObj = new user();
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$userArray = array('fname' => $fname, 'lname' => $lname,
			'email' => $email,
			'password' => $password,
			'source' => 'S');

		if (!$userObj->createUser($userArray)) {
			//we weren't successful in creating an account
			throw new MyException('Was not able to register your account. Please try using a different email address or use forgot password to recover your credentials.');
		} else {
			header('Location: /auth/login.php');
			exit();
		}
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
		array_push($_websiteErr, $e->getMessage());
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
<head>
	<title>Tackster | Register Account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Style Sheets -->
	<link rel="stylesheet" type="text/css" href="/shared/css/base.css" />
	<link rel="stylesheet" type="text/css" href="/shared/css/registerStyle.css" />
	<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>



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
    <!-- Navigation Bar - DON'T use navbar.php as this navigation bar is specific to resgister.php alone -->
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
						<a class="btn btn-default" href="/auth/login.php" role = "button" style=" margin: 0 -10px 0px 0">Login</a>
                    </p>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <!-- /Navigation Bar -->


    <!-- Body Content-->
    <div class="container" style="margin-top: 80px;">
        <section id="content">
            <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" name="formLogin" id="formRegister">
                <h1>Sign Up</h1>
				<?php
				if (count($_websiteErr) > 0 || $_websiteErr != NULL) {
					echo $_websiteErr;
				}
				?>
                <div>
					<p>First Name:&nbsp;<input type="text" required="" id="fname" name ="fname" autofocus=""/></p>
                </div>
                <div>
					<p>Last Name:&nbsp;<input type="text" required="" id="lname" name ="lname"/></p>
                </div>
                <div>
					<p>Email:&nbsp;<input type="text" required="" id="email" name ="email" /></p>
                </div>
                <div>
					<p>Password:&nbsp;<input type="password" required="" id="password" name ="password" /></p>
                </div>
                <div>
					<button class="btn btn-success" type="submit" name="submit">Sign Up</button>
					<button href="/" class="btn btn-danger" type="cancel" >Cancel</button>
                </div>
            </form><!-- form -->
            <h6><span  class="line-center">OR</span></h6>
            <a href="#" onClick="MyWindow=window.open('https://www.facebook.com/login.php?skip_api_login=1&api_key=294846713986884&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fdialog%2Foauth%3Fredirect_uri%3Dhttp%253A%252F%252F153.18.33.144%252FDEV%252F%26state%3D7a56d86c0a6c372440bf849d630e2a27%26scope%3Demail%26client_id%3D294846713986884%26ret%3Dlogin&cancel_uri=http%3A%2F%2F153.18.33.144%2FDEV%2F%3Ferror%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied%26state%3D7a56d86c0a6c372440bf849d630e2a27%23_%3D_&display=page','MyWindow',width=20,height=30); return false;">
                <img src= "http://i.imgur.com/lYI2b73.png" alt="Sign Up with Facebook" class= "img-rounded"/><br/>
            </a>
        </section>
    </div>
	<!-- /Body Content-->

	<!-- Footer Content -->
	<?php require_once('html/footer.php'); ?>
	<!-- /Footer Content -->

</body>
</html>