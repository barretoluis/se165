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


?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Search Bookmarks</title>
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
		<!-- Navigation Bar -->
		<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->


		<!-- Body Content-->
		<div id="quickSearch" class="main" >
			<h3>Search Bookmarks</h3>
			<?php if ($formError) { ?>
				<div class="formError"><h4>Form Error</h4><?php echo $formError ?></div>
			<?php } ?>

			<p>Look for bookmarks matching your interest.</p>
			<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="searchBookmarks" id="searchBookmarks">
				Search Words: <input type="text" name="searchWord" value="<?php echo_formData($searchWord) ?>" size="20" maxlength="80"><input type="submit" name="submit" id="submit" value="Submit">
			</form>


			<p><br></p>
			<hr style="border-color:grey;" width=100% align=left>
			<h4>Search Results</h4>

			<p><?php
			if ($formSubmitted && count($_bookmarks) >= 1) {
				//we have a search result with entries
				print_r($_bookmarks);
			} else {
				print("<p class='noSearchResults'>No search results were found.</p>");
			}
			?></p>

		</div>
		<!-- /Body Content-->
	</body>
</html>