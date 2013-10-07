<?php
require_once 'Bookmark/SearchBookmark.class.php';


/*
 * Search logic for header search form.
 */
$keyword = NULL; //search terms from form
$_bookmarks = NULL; //return results of found bookmarks as an array
$formError = NULL; //form error messages to show end user on web page
$formSubmitted = FALSE; //flag if form was submitted

//TODO: Before running logic, check if the search form was submitted

if (isset($_POST['keyword']) || isset($_GET['keyword'])) {
	//prefer a post variable over a get
	$keyword = (isset($_POST['keyword']) ? $_POST['keyword'] : $_GET['keyword']);

	//Do a search for the keyword
	if (strlen($keyword) >= 1) { //was a keyword even submitted
		try {
			$getBookmark = new SearchBookmark();
			$_bookmarks = $getBookmark->getBookmark($keyword);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
		$formSubmitted = TRUE;
	} else {
		$formError = "No search terms were provided in the Bookmark Search.";
	}
}
?>
