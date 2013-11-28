<?php

/*
 * This file contains all the necessary includes needed for a basic page.
 */

/*
 * Debugging Settings
 */
error_reporting(E_ALL);
ini_set('display_errors', 'On');


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
	'mandrillApi.php',
	'Auth/User.class.php',
	'Track/Track.class.php'
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

	if (ini_get('display_errors') == 1 || ini_get('display_errors') == 'On') {
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
 * Business logic after libs have loaded
 */
//Login Test
$loggedIn = (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) ? TRUE : FALSE;
$ignorePageLogin = (isset($ignorePageLogin)) ? $ignorePageLogin : FALSE;
$_pagesToIgnore = Array(
	'/',
	'/index.php',
	'/auth/login.php',
	'/auth/loginFacebook.php',
	'/auth/register.php',
	'/auth/logout.php',
	'/auth/forgotPassword.php',
	'/company/about/index.php',
	'/company/terms_and_privacy/index.php',
	'/test/index.php'
);

if ($ignorePageLogin != FALSE || (!$loggedIn && !in_array($_SERVER['PHP_SELF'], $_pagesToIgnore))) {
	header('Location: /');
}




//let's check if a search was done
require_once('Bookmark/headerSearch.php');
?>