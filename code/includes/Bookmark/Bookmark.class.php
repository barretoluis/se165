<?php

/**
 * This class provides information pertaining to bookmarks.
 * It contains a URL, a description and keywords. The UI takes these variables
 * to display the bookmark with its title, description and image
 *
 * @author Jerry Phul
 */
require_once 'DataBase.php';
//require_once __DIR__ . '\..\DataBase.php';
class Bookmark {

	private $_errorMsgs = Array();
	private $_bookmarks = Array();
	private $_comments = Array();
	private $ucId;
	private $defaultTid;
	private $trackId;
	private $bmkId;

	/*
	 * Standard constructor
	 *
	 */

	public function __construct() {
		$this->setUcId($_SESSION['uc_id']);
		$this->setDefaultTid($_SESSION['defaultTrackId']);

		if ($this->getUcId() < 0) {
			throw new MyException('Could not determine the User ID while constructing the bookmark object.');
		}
	}

	/**
	 * Create the standard bookmark object and insert into DB.
	 *
	 * @param type $trackId The ID of the track the bookmark should be added to.
	 * @param type $url The URL of the destination bookmark.
	 * @param type $privacy 1 if private or 0 for public access.
	 * @param type $description The description of the bookmark.
	 * @param type $keyword Comma separated list of keywords for the bookmark.
	 *
	 * @return array Return user friendly error messages if any.
	 *
	 */
	public function createBookmark($trackId, $url, $privacy, $description, $keyword = NULL) {
		if ($trackId == NULL || $url == NULL || $description == NULL) {
			throw new MyException('One of the parameters was not provided for the bookmark.');
		}

		$this->setBookmarks(NULL);
		$this->setTrackId($trackId);

		//let's make sure to tie the query to the uc_id
		$query = "INSERT INTO bmk_entry (uc_id, t_id, url, privacy, keyword, description)
					VALUES ('{$this->getUcId()}', '{$this->getTrackId()}', '{$url}', '{$privacy}', '{$keyword}', '{$description}')";

		try {
			//Construct DB object
			$sqlObj = new DataBase();

			//Execute query
			$sqlObj->DoQuery($query);
		} catch (MyException $e) {
			array_push($this->_errorMsgs, 'Was not able to create the bookmark. Please make sure required fields are filled in.');
			$e->getMyExceptionMessage();
		}

		// Destroy the DB object
		$sqlObj->destroy();

		try {
			if (count($this->_errorMsgs) < 1) {
				$this->returnBmkDataByTrack($this->getTrackId());
			}
		} catch (MyException $e) {
			array_push($this->_errorMsgs, 'Was not able to get your current list of tracks. Please log out and log back in to see if issue is resolved.');
			$e->getMyExceptionMessage();
		}

		return $this->_errorMsgs;
	}

	/**
	 * Return a bookmark and all it's data.
	 * @param int $bmkId For a given bookmark ID, return its data.
	 * @return array Result only contains one entry of the bookmark requested.
	 */
	public function returnBookmark($bmkId) {
		if ($bmkId == NULL) {
			throw new MyException('One of the parameters was not provided for the bookmark.');
		}

		$this->resetObject();
		$this->setBmkId($bmkId);

		//let's make sure to tie the query to the uc_id
		$query = "SELECT * FROM bmk_entry WHERE id='" . $this->getBmkId() . "'";

		try {
			//Construct DB object
			$sqlObj = new DataBase();

			//Execute query
			$sqlObj->DoQuery($query);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}

		// Destroy the DB object
		$sqlObj->destroy();

		$this->setBookmarks($sqlObj->GetData());

		return $this->getBookmarks();
	}

	/**
	 * Provided the user's ID, check to see if they have permission to view the bookmark.
	 *
	 * @param int $uc_id	The user's credential ID in the DB.
	 * @param int $bmkId	The ID of the bookmark who's permission should be checked.
	 * @return boolean		TRUE if user has permissions to view the bookmark.
	 * @assert (73, 13) == TRUE
         * @assert (72, 13) == FALSE
	 */
	public function canViewBmk($uc_id, $bmkId) {
		if ($uc_id == NULL || $bmkId == NULL) {
			throw new MyException('One of the parameters was not provided for the bookmark.');
		}

		$canView = FALSE;
		$this->setBmkId($bmkId);

		try {
			$this->returnBookmark($this->getBmkId());
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}

		$bmkUcId = (isset($this->_bookmarks[0]['uc_id'])) ? $this->_bookmarks[0]['uc_id'] : FALSE;
		$privacyValue = (isset($this->_bookmarks[0]['privacy']) && $this->_bookmarks[0]['privacy'] == 1) ? TRUE : FALSE;

		if ($bmkUcId == $this->getUcId()) {
			$canView = TRUE;
		} elseif ($bmkUcId != $this->getUcId() && $privacyValue == FALSE) {
			//the bookmark privacy is set to public
			$canView = TRUE;
		}

		return $canView;
	}

	/**
	 * Get all the bookmarks and their data for a given Track ID.
	 * This method also assumes the user's credential ID was already set as a session object.
	 * This assures only bookmarks are returned for the authorized user.
	 *
	 * @param int $trackId	The ID of the track to get bookmarks for.
	 * @return array Returns an array of all bookmark data from the DB.
         *
	 */
	public function returnBmkDataByTrack($trackId) {
		if ($trackId == NULL) {
			throw new MyException('No track ID provided.');
		}

		$this->resetObject();
		$this->setTrackId($trackId);
		$this->setBmkId(NULL); //Reset id since this will not be a single bookmark
		//let's make sure to tie the query to the uc_id
		$query = "SELECT * FROM bmk_entry WHERE t_id='" . $this->getTrackId() . "' AND uc_id='" . $this->getUcId() . "'";

		try {
			//Construct DB object
			$sqlObj = new DataBase();

			//Execute query
			$sqlObj->DoQuery($query);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}

		// Destroy the DB object
		$sqlObj->destroy();

		$this->setBookmarks($sqlObj->GetData());

		return $this->getBookmarks();
	}

	/**
	 * Return the comments for a given bookmark entry.
	 *
	 * @param int $bmkId ID of bookmark to get data for from DB..
	 * @return array Returns an array of all bookmark comments from the DB.
	 */
	public function returnBmkComments($bmkId) {
		$this->setBmkId($bmkId);

		if ($this->getBmkId() == NULL) {
			throw new MyException('No bookmark ID provided.');
			return NULL;
		}

		//let's make sure to tie the query to the uc_id
		$query = "select * from `v_returnBookmarkComments` where be_id='" . $this->getBmkId() . "'";

		try {
			//Construct DB object
			$sqlObj = new DataBase();

			//Execute query
			$sqlObj->DoQuery($query);
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}

		// Destroy the DB object
		$sqlObj->destroy();

		$this->setComments($sqlObj->GetData());

		return $this->getComments();
	}

	/**
	 * Reset this objects varibles.
	 * @assert () == TRUE
	 */
	private function resetObject() {
		$this->setBmkId(NULL);
		$this->setBookmarks(NULL);
		$this->setComments(NULL);
		$this->setDefaultTid(NULL);
		$this->setTrackId(NULL);
		return TRUE;
	}

	/*	 * ************************************************************************
	 * SETTERS and GETTERS
	 */

	/**
	 * Populate private variable with from passed in bookmark data.
	 *
	 * @param array $_bookmarks Set the bookmarks array with bookmark data from the DB.
	 * @assert () == expectedResult
	 */
	private function setBookmarks($_bookmarks) {
		$this->_bookmarks = (array) $_bookmarks;
	}

	/**
	 * Get the DB results of bookmarks data.
	 *
	 * @return array  Return the bookmarks array with bookmark data.
	 */
	private function getBookmarks() {
		return $this->_bookmarks;
	}

	/**
	 * Set the default track id variable..
	 *
	 * @param int $defaultTid Set the user's default track id.
	 */
	private function setDefaultTid($defaultTid) {
		$this->defaultTid = (int) $defaultTid;
	}

	/**
	 * Get the default track id variable.
	 *
	 * @return int  Id of the user's default track.
	 */
	private function getDefaultTid() {
		return $this->defaultTid;
	}

	/**
	 * Set the user's credential ID.
	 *
	 * @param int $ucId Set the user's ID.
	 */
	private function setUcId($ucId) {
		$this->ucId = (int) $ucId;
	}

	/**
	 * Get the user's credential ID.
	 *
	 * @return int User's ID.
	 */
	private function getUcId() {
		return $this->ucId;
	}

	/**
	 * Set TrackId variable.
	 *
	 * @param string $trackId ID of the track for which the bookmark should be related to.
	 */
	private function setTrackId($trackId) {
		$this->trackId = (int) $trackId;
	}

	/**
	 * Get URL variable.
	 *
	 * @return int ID of the track for which the bookmark should be related to.
	 */
	private function getTrackId() {
		return $this->trackId;
	}

	/**
	 * Set bookmark ID.
	 *
	 * @param int $bmkId Bookmark id in the DB.
	 */
	private function setBmkId($bmkId) {
		$this->bmkId = (int) $bmkId;
	}

	/**
	 * Get bookmark id variable.
	 *
	 * @return int Bookmark id in the DB.
	 */
	private function getBmkId() {
		return $this->bmkId;
	}

	/**
	 * Set the array with comments from a given bookmark.
	 *
	 * @param array $_comments Result set from DB of the comments.
	 */
	private function setComments($_comments) {
		$this->_comments = (array) $_comments;
	}

	/**
	 * Get bookmark id variable.
	 *
	 * @return array Result set from DB of the comments.
	 */
	private function getComments() {
		return $this->_comments;
	}

}

?>
