<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
	'Keyword/KeywordManager.class.php'
);




/*
 * Require mandatory libraries to be loaded.
 * Else, redirect to server outage page.
 *
 */
// DO NOT EDIT THIS BLOCK
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




/*
 * Page specific PHP code here
 */
$keyword = NULL;
$_keywords = NULL;

if(isset($_POST['keyword']) || isset($_GET['keyword'])) {
	//prefer a post variable over a get
	$keyword = (isset($_POST['keyword']) ? $_POST['keyword']: $_GET['keyword']);

	//Do a search for the keyword
	$getKeyword = new KeywordManager();
	$_keywords = $getKeyword->getKeyword($keyword);
}


?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Search</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<link href="/framework/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">

		<!-- Style Sheets -->
		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">
		<link href="/shared/css/home.css" rel="stylesheet" type="text/css">

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
		<h1>Tackster</h1>
		<ul>
			<li><a href="/company/about/">About</a></li>
			<li><a href="/company/terms_and_privacy/">Terms & Privacy</a></li>
		</ul>


		<hr style="border-color:grey;" width=85% align=left>
		<h2>Search</h2>
		<p>In a tempor ante. Fusce suscipit, arcu a tincidunt imperdiet, sapien magna blandit arcu, sed dapibus neque nisl a magna. Curabitur malesuada molestie lorem, eget tristique sapien cursus in. Etiam facilisis magna ut ornare viverra. Maecenas interdum enim ut nunc condimentum.</p>




		<hr style="border-color:grey;" width=85% align=left>
		<h3>Quick Search</h3>
		<p>This search will be used with the JQuery widget.</p>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="searchQuick" id="searchQuick">
			Keyword: <input type="text" name="keyword" value="goo" size="20" maxlength="40"><input type="submit" name="submit" id="submit" value="Submit">
		</form>




		<hr style="border-color:grey;" width=85% align=left>
		<h3>Advanced Search</h3>
		<p>This is the long form search that will be available for granular searching.</p>





		<p><br></p>
		<hr style="border-color:grey;" width=100% align=left>
		<h4>Search Results</h4>

	</body>
</html>