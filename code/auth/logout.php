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
//If you don't have a session or haven't logged in, redirect to homepage
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == FALSE) {
			header('Location: /');
}

//if user is logged in, let's log them out and redirect to homepage
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
	//Looks like someone is trying to login
	try {
		$userObj = new User();
		$userObj->logOutUser();
	} catch (MyException $e) {
		$e->getMyExceptionMessage();
	}
}

header('Location: /');
?>