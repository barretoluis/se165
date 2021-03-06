<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
	'Keyword/KeywordManager.class.php'
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
$keyword = NULL;  //search keywords from form
$_keywords = NULL;  //return results of found keywords as an array
$formError = NULL;  //form error messages to show end user on web page
$formSubmitted = FALSE; //flag if form was submitted

if (isset($_POST['keyword']) || isset($_GET['keyword'])) {
	//prefer a post variable over a get
	$keyword = (isset($_POST['keyword']) ? $_POST['keyword'] : $_GET['keyword']);

	//Do a search for the keyword
	if (strlen($keyword) >= 1) { //was a keyword even submitted
		try {
			$getKeyword = new KeywordManager();
			$_keywords = $getKeyword->getKeyword($keyword);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
	} else {
		if (isset($_POST)) {
			$formError = "No search terms were provided in the Quick Search.";
		} elseif (isset($_GET)) {
			$formError = NULL; //a web service will be make GET requests, so send a null
		}
	}
	$formSubmitted = TRUE;
}
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Quick Search</title>
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
                <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
                <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
                <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
                
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>
                   
                <script>
		jQuery(document).ready(function($){
			$('#autocompleteSearch').autocomplete({source:'autocomplete.php', minLength:2});
		});
                </script>
        
		<style type = "text/css">

		</style>
	</head>


	<body>
		<!-- Navigation Bar -->
		<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->


		<!-- Body Content-->
		<div id="quickSearch" class="main" >
			<h3>Quick Search</h3>
			<?php if ($formError) { ?>
				<div class="formError"><h4>Form Error</h4><?php echo $formError ?></div>
			<?php } ?>

			<p>This search will be used with the JQuery widget.</p>
			<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="searchQuick" id="searchQuick">
				Keyword: <input type="text" id="autocompleteSearch" name="keyword" value="<?php echo $keyword ?>" size="20" maxlength="40"><input type="submit" name="submit" id="submit" value="Submit">
			</form>


			<p><br></p>
			<hr style="border-color:grey;" width=100% align=left>
			<h4>Search Results</h4>

			<p><?php
                        //we have a search result with entries
			if ($formSubmitted && count($_keywords) >= 1) 
                        { 
                            //Need to reformat array so it is readable by JQuery autocomplete
                            //Note: Still not working within searchQuick.php, using autocomplete.php as input source
                            foreach ($_keywords as &$readable) 
                            {
                                $autoCompleteData[] = array(
                                'label' => $readable['keyword'],
                                'value' => $readable['keyword']
                                );
                            }   
                                //echo json_encode($autoCompleteData);
                                //flush();
                                print_r($_keywords);
                                //print_r($autoCompleteData);
				//print(json_encode($_keywords));
                                //print(json_encode($_autoCompleteData));
			} 
              
                        else 
                        {
				print("<p class='noSearchResults'>No search results were found.</p>");
			}
			?></p>

		</div>
		<!-- /Body Content-->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->

	</body>
</html>