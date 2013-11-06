<?php

/**
 * This class provides information pertaining to bookmarks.
 * It contains a URL, a description and keywords. The UI takes these variables
 * to display the bookmark with its title, description and image
 *
 * @author Jerry Phul
 */
require_once 'DataBase.php';

class Bookmark {
	private $_bookmarks = Array();
	private $ucId;
	private $defaultTid;
	private $trackId;
	private $_errorMsgs = Array();

	/*
	 * Standard constructor
	 *
	 */

	public function __construct() {
		$this->setUcId($_SESSION['uc_id']);
		//$this->setDefaultTid($_SESSION['defaultTrackId']);

		if ($this->getUcId() < 0) {
			throw new MyException('Could not determine the User ID while constructing the bookmark object.');
		}
	}

	/**
	 * Create the standard bookmark object.
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
			$e->getMyExceptionMessage();
		}

		// Destroy the DB object
		$sqlObj->destroy();

		$this->getBmkDataByTrack($this->getTrackId());

		return $this->_errorMsgs;
	}

	/**
	 * Create the standard bookmark object.
	 *
	 * @param int $bmkId ID of bookmark to get data for from DB. If NULL, return the existing object's data.
	 * @return array Returns an array of all bookmark data from the DB.
	 */
	public function getBmkDataByTrack($trackId) {
		$this->setTrackId($trackId);

		if ($this->getTrackId() == NULL) {
			throw new MyException('No track ID provided.');
		}

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
	 * Set Bookmarks variable.
	 *
	 * @param array $_bookmarks Set the bookmarks array with bookmark data.
	 */
	private function setBookmarks($_bookmarks) {
		$this->_bookmarks = $_bookmarks;
	}

	/**
	 * Get URL variable.
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
		$this->defaultTid = $$defaultTid;
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
	 * Set TrackId variable.
	 *
	 * @param string $trackId Set the user's ID.
	 */
	private function setUcId($ucId) {
		$this->ucId = (int) $ucId;
	}

	/**
	 * Get URL variable.
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
	 * @return string ID of the track for which the bookmark should be related to.
	 */
	private function getTrackId() {
		return $this->trackId;
	}

}

?>
