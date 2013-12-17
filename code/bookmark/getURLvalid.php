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
$getUrlData = (isset($_GET['url'])) ? $_GET['url'] : NULL;

processUrl($getUrlData);

function processUrl($url = NULL) {
	try {
		$_headers = @get_headers($url);
		if (preg_match("/200/", $_headers[0])) {
			header("HTTP/1.1 200 OK");
			//printHeaders($url);
			exit;
		} elseif (preg_match("/301/", $_headers[0]) || preg_match("/302/", $_headers[0])) {
			$redirHeaderKey = findLocation($_headers);
			$redirUrl = $_headers[$redirHeaderKey];
			$redirUrl = preg_replace('/Location:\W+/', '', $redirUrl);
			processUrl($redirUrl);
		}
	} catch (MyException $e) {
	}

	header("HTTP/1.0 404 Not Found");
	echo '<h1>404 Remote Page Not Found</h1>';
	exit;
}

function findLocation($arr) {
	foreach ($arr as $key => $value) {
		if (preg_match("/Location:/i", $value)) {
			return $key;
		}
	}
	return FALSE;
}

function printHeaders($url) {
	$_headers = @get_headers($url);
	echo '<pre>';
	print_r($_headers);
	echo '</pre>';
}

?>
