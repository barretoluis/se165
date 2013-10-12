<?php

/*
 * This file contains all the necessary includes needed for a basic page.
 */

/*
 * Debugging Settings
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');


/*
 * Start basic session
 */
if (!isset($_SESSION)) {
	session_start();
}


/*
 * List all required libs for this page
 */
$includeFilesMain = array(
	'Utility/MyException.class.php',
	'Utility/EnvUtilities.class.php',
	'faceBookApi.php',
	'mandrillApi.php',
	'Auth/User.class.php'
);

//Do we have more files to include in this page
if (isset($includeFilesAdditional) && count($includeFilesAdditional) > 0) {
	$includeFiles = array_merge($includeFilesMain, $includeFilesAdditional);
} else {
	$includeFiles = $includeFilesMain;
}

//let's include all the libraries for this page
try {
	// require the primary include file
	foreach ($includeFiles as $file) {
		if (!include_once($file))
			throw new Exception("Unable to include the library: $file.\n");
	}
} catch (Exception $e) {
	// send the browser a 500 error
	header('HTTP/1.1 500 Internal Server Error', true, 500);

	$err = "<br><b>EXCEPTION</b>\n";
	$err .= "<br><b>File:</b> " . $e->getFile() . "\n";
	$err .= "<br><b>Line:</b> " . $e->getLine() . "\n";
	$err .= "<br><b>Message:</b> " . $e->getMessage() . "\n";
	$err .= "<br><b>Trace:</b><br>" . $e->getTraceAsString() . "\n";

	if (ini_get('display_errors') == 1) {
		//display errors to web page is on
		print($err);
		error_log(strip_tags($err));
	} else {
		//only send the exception to the error log
		error_log(strip_tags($err));
	}

	// if any exception was encountered during the include loading process,
	// we need to exit out. This prevents any security errors.
	exit(0);
}

/*
 * Cleanup POST, GET and COOKIE variables before we do anything with them.
 * This is to prevent SQL injection, XSS, etc.
 */
$secureVarContent = new EnvUtilities();
$secureVarContent->disable_magic_quotes();


/*
 * Facebook login code
 */
$faceBookObj = new faceBookApi();
$userObj = new user();
$registered = FALSE;
$exists = $faceBookObj->setUserState();
$logout = '<a href="' . $faceBookObj->getLogOutUrl() . '">; <img src="images/logoutFB.png" alt="logout" class="img-rounded"></a>';

//$_SESSION['logoutURL'] = $fbButton;
if ($exists) {
	$fbButton = '<a href="' . $faceBookObj->getLogOutUrl() . '">;
                    <img src="images/logoutFB.png" alt="logout" class="img-rounded"></a>';
	$_SESSION['logoutURL'] = $fbButton;
	$fbinfo = $faceBookObj->getUserProfile();
	$registered = $userObj->searchUser($fbinfo['email']);
	$_SESSION['profile'] = $fbinfo;
	if (!$registered) {
		$userArray = array('fname' => $fbinfo['first_name'],
			'lname' => $fbinfo['last_name'],
			'email' => $fbinfo['email'],
			'password' => '',
			'gender' => $fbinfo['gender'],
			'source' => 'F');
		$userObj->createUser($userArray);
		header('Location:dashboard.php');
	} else {
		header('Location:dashboard.php');
	}
} else {
	$fbButton = '<a href="' . $faceBookObj->getLoginUrl() . '">;
                    <img src="images/loginFB.png" alt="Login using Facebook" class="img-rounded"></a>';
}

/*
 * Business logic after libs have loaded
 */
//Login Test
$loggedIn = (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) ? TRUE : FALSE;
$ignorePageLogin = (isset($ignorePageLogin)) ? $ignorePageLogin: FALSE;
$_pagesToIgnore = Array(
	'/',
	'/index.php',
	'/auth/login.php',
	'/auth/register.php',
	'/auth/logout.php'
);

if($ignorePageLogin != FALSE && (!$loggedIn && !in_array($_SERVER['PHP_SELF'], $_pagesToIgnore))) {
	header('Location: /');
}





//let's check if a search was done
require_once('Bookmark/headerSearch.php');
?>