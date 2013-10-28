<?php
require_once 'Utility/MyException.class.php';
require_once 'Bookmark/SearchBookmark.class.php';


/*
 * Search logic for header search form.
 *
 * @author Jerry Phul
 */
$searchWord = NULL; //search terms from form
$_bookmarks = NULL; //return results of found bookmarks as an array
$formError = NULL; //form error messages to show end user on web page
$formSubmitted = FALSE; //flag if form was submitted
//TODO: Before running logic, check if the search form was submitted

if (isset($_POST['searchWord'])) {
	//prefer a post variable over a get
	$searchWord = $_POST['searchWord'];

	//Do a search for the search words
	if (strlen($searchWord) >= 1) { //was a keyword even submitted
		try {
			$getBookmark = new SearchBookmark();
			$_bookmarks = $getBookmark->getBookmark($searchWord);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
	} else {
			$formError = "No search terms were provided in the Bookmark Search.";
	}
	$formSubmitted = TRUE;
}
?>
