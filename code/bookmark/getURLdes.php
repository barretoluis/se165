<?php

/**
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
$_tags = NULL;
$getUrlData = (isset($_GET['url'])) ? $_GET['url'] : NULL;
$urlPattern = "/^https?:\/\/.+\..+/i";
$_matches = NULL;
preg_match($urlPattern, $getUrlData, $_matches);

//let's only do a lookup if the URL is formed correctly
if (isset($_matches[0])) {
	try {
		$_tags = @get_meta_tags($getUrlData);
		if (isset($_tags['description'])) {
			echo_formData($_tags['description']);
		}
	} catch (MyException $e) {
		//looks like no meta tags were found
		//$e->getMyExceptionMessage();
	}
}

?>
