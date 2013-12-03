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
$formAction = NULL;
$formField = "disabled";
$updateStatus = NULL;
$nameFirst = (isset($_SESSION['profile']['first'])) ? $_SESSION['profile']['first'] : NULL;
$nameLast = (isset($_SESSION['profile']['last'])) ? $_SESSION['profile']['last'] : NULL;
$nameUser = (isset($_SESSION['profile']['username'])) ? $_SESSION['profile']['username'] : NULL;
$emailUser = (isset($_SESSION['profile']['email'])) ? $_SESSION['profile']['email'] : NULL;
$userSex = (isset($_SESSION['profile']['sex'])) ? $_SESSION['profile']['sex'] : NULL;

if (isset($_POST['formAction']) && $_POST['formAction'] == "saveProfile") {
	$nameFirst = (isset($_POST['fname'])) ? $_POST['fname'] : NULL;
	$nameLast = (isset($_POST['lname'])) ? $_POST['lname'] : NULL;
	$nameUser = (isset($_POST['username'])) ? $_POST['username'] : NULL;
	$userSex = (isset($_POST['gender'])) ? $_POST['gender'] : NULL;
	//TODO: Temp fix implemented to resolve bug 65
	//		Go back and remove email requirement from updteUser method.
	//		Will need to do regression testing.
	$_POST['email'] = $emailUser;

	//let's make sure all fields data was provided in the form post
	if (!$nameFirst || !$nameLast || !$nameUser || !$userSex || !$emailUser) {
		$_POST['formAction'] = 'edit';
		array_push($_websiteErr, 'Please complete all profile fields.');
	} else {
		try {
			$updateProfile = new User();
			$updateStatus = $updateProfile->updateUser($_SESSION['uc_id'], $_POST);
			if (isset($_POST))
				unset($_POST); //no longer need the POST variables
			$formStatus = "edit"; //updated successfully so show profile
			header('Location: ' . $_SERVER['PHP_SELF'] . '');
			exit();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
	}
} elseif (isset($_POST['formAction']) && $_POST['formAction'] == "edit") {
	$formAction = "edit";
	$formField = "";
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
		<!-- Body Content-->
		<div class="profile">
			<h3>My Profile</h3>
			<style>
				.input[readonly] {
					background: #CCC;
					color: #333;
					border: 1px solid #666
				}
			</style>
			<div class="container">
				<div class="well">
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="formProfileView" id="formProfileView">
						<?php
						if (count($_websiteErr) > 0 || $_websiteErr != NULL) {
							echo $_websiteErr;
						}
						?>
						<table>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;First Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>
									<input type = "text" name = "fname" id = "fname" value="<?PHP echo_formData($nameFirst) ?>" maxlength="20" <?php echo $formField ?>/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;Last Name:</td>
								<td><input type="text" name="lname" id="lname" value="<?PHP echo_formData($nameLast) ?>" maxlength="20" <?php echo $formField ?>/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;Username:</td>
								<td><input type="text" name="username" id="username" value="<?PHP echo_formData($nameUser) ?>" maxlength="20"  <?php echo $formField ?>/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;Email:</td> <!-- Should they be allowed to change their email address?-->
								<?PHP /* <td><input type="email" name="email" id="email" value="<?PHP echo_formData($emailUser) ?>"  <?php echo $formField ?>/> */ ?>
								<td><?PHP echo_formData($emailUser) ?>
								</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;Password:</td> <!--Should we give them an opportunity to change password? if not see it? -->
								<td>
									<input type="password" name="password" id="password"  <?php echo $formField ?> placeholder="Enter New Password to Reset"/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;&nbsp;&nbsp;Gender:</td>
								<td>
                                    <label class="radio inline"><input type="radio" name="gender" value="m" <?php if ($userSex == "m") echo "checked"; ?> <?php echo $formField ?> > Male &nbsp;&nbsp;</label>
                                    <label class="radio inline"><input type="radio" name="gender" value="f" <?php if ($userSex == "f") echo "checked"; ?>  <?php echo $formField ?> > Female </label>
								</td>
							</tr>
						</table>
						<?php if ($formAction == 'edit') { ?>
							<br/>
							<input type="hidden" name="formAction" value="saveProfile">
							<p><button class="btn btn-success" type="submit" on-click="<?php echo$_SERVER['PHP_SELF'] ?>">Save Profile</button></p>
						<?php } else { ?>
						</form>
						<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" name="formProfileUpdate" id="formProfileUpdate">
							<input type="hidden" name="formAction" value="edit">
							<p><button class="btn btn-success" type="submit" on-click="<?php echo$_SERVER['PHP_SELF'] ?>">Edit Profile</button></p>
						<?php } ?>
					</form>
				</div>
			</div>
		</div>
		<!-- /Body Content-->
	</body>
</html>