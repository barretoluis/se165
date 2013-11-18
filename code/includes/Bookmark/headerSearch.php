<?php

require_once 'Utility/MyException.class.php';
require_once 'Bookmark/SearchBookmark.class.php';


/*
 * Search logic for header search form.
 *
 * @author Jerry Phul
 */
$ucId = (isset($_SESSION['uc_id'])) ? (int) $_SESSION['uc_id'] : NULL;
$_tid = array(); //search your specific track
$_websiteErr = array();
$searchWord = NULL; //search terms from form
$_bookmarks = NULL; //return results of found bookmarks as an array
$formError = NULL; //form error messages to show end user on web page
$formSubmitted = FALSE; //flag if form was submitted
//TODO: Before running logic, check if the search form was submitted

if (isset($_POST['searchWord'])) {
	//prefer a post variable over a get
	$searchWord = $_POST['searchWord'];
	$searchPublicTrks = (isset($_POST['publicTracks']) && $_POST['publicTracks'] == 1) ? TRUE : NULL; //user wants to search pub tracks only
	$searchMyTrks = (isset($_POST['myTracks']) && $_POST['myTracks'] == 1) ? TRUE : NULL; //user wants to search personal tracks only
	$_tid = (isset($_POST['tid'])) ? $_POST['tid'] : array(); //values come in as array
	//Do a search for the search words
	if (strlen($searchWord) >= 1 && strlen($searchWord) <= 40) { //was a keyword even submitted
		try {
			$getBookmark = new SearchBookmark();
			if($searchPublicTrks) {
				//search public tracks
				$htmlHeadTitle = "Searching All Public Tracks";
				$_bookmarks = $getBookmark->searchPublicBookmarks($searchWord);
			} elseif($searchMyTrks) {
				//search all personal tracks
				$htmlHeadTitle = "Searching All Personal Tracks";
				$_bookmarks = $getBookmark->searchMyBookmarks($searchWord, $ucId);
			} elseif(count($_tid)>0) {
				//search specific personal tracks
				$htmlHeadTitle = "Searching Some Personal Tracks";
				$_bookmarks = $getBookmark->searchMyTrackBookmarks($searchWord, $ucId, $_tid);
			} else {
				array_push($_websiteErr, 'I am smart but not that smart to read your mind. Give some tracks to search against and help me narrow in by a few key terms as well. Shall we try again?');
			}
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
	} else {
		array_push($_websiteErr, 'No search terms were provided or it may be to long for searching. Please try another search term.');
	}
	$formSubmitted = TRUE;
}
?>
