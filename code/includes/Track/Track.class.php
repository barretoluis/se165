<?php

require_once 'DataBase.php';

/** This class defines a track.
 * A track holds bookmarks/tacks.
 * This class provides functionality to create, search, delete and modify tracks
 * associated with the user account.
 *
 *  @author Luis Barreto
 */
class Track {

	private $sqlObj;
	private $trackId;
	//private $boardId;
	private $ucId;
	private $title;
	private $description;
	private $private;
	private $flag_default;

	/**
	 * Standard constructor that creates a sql Database object
	 *
	 */
	public function __construct() {
		$this->sqlObj = new DataBase();
	}

	/**
	 * This function creates a track based upon the passed array.
	 * It then passes that data, via a query, into the database.
	 * @param int		$userId	The user credential ID.
	 * @param string	$title	Title for the track.
	 * @param string	$desc	Description of the track.
	 * @param char		$privacy	T for private and F for public.
	 * @param boolean	$isDefaultTrack	TRUE if this is being created as a default track.
	 */
	public function createTrack($userId, $title, $desc, $privacy, $isDefaultTrack = FALSE) {
		if ($isDefaultTrack == TRUE) {
			$title = 'My Private Bookmarks';
			$desc = 'This is your default track with private bookmarks.';
			$privacy = 'T';
			$flag_default = '1';
		} elseif ($userId == NULL || $title == NULL || $desc == NULL || $privacy == NULL) {
			throw new MyException('A required field was not provided for creatign a new track.');
		} else {
			$flag_default = 0; //1 if this should be flagged as a default track
		}

		$this->ucId = (isset($userId)) ? $userId : NULL;
		$this->title = (isset($title)) ? $title : NULL;
		$this->description = (isset($desc)) ? $desc : NULL;
		$this->private = (isset($privacy)) ? $privacy : NULL;
		$this->flag_default = (isset($flag_default)) ? $flag_default : NULL;

		$query = "INSERT INTO  `track` (
                    `id` ,
                    `uc_id`,
                    `title` ,
                    `description` ,
                    `private`,
                    `flag_default`
                )
                VALUES (
                    NULL , '$this->ucId',  '$this->title',  '$this->description',
                    '$this->private', '$this->flag_default'
                );";

		try {
			$trackId = $this->sqlObj->DoQuery($query);
			$this->sqlObj->destroy();

			//force the session to reset its tracks
			if (isset($_SESSION['myTracks'])) {
				unset($_SESSION['myTracks']);
			}
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			return -1;
		}

		return $trackId;
	}

	/**
	 * This function updates a track based upon the passed data.
	 * It then passes that data, via a query, into the database.
	 * @param int		$ucId	The user credential ID.
	 * @param int		$tid	The track ID.
	 * @param string	$title	Title for the track.
	 * @param string	$desc	Description of the track.
	 * @param char		$privacy	T for private and F for public.
	 * @param boolean	$isDefaultTrack	TRUE if this is being created as a default track.
	 */
	public function updateTrack($ucId, $tid, $title, $desc, $privacy) {
		if ($ucId == NULL || $tid == NULL || $title == NULL || $desc == NULL || $privacy == NULL) {
			throw new MyException('A required field was not provided for updating this track.');
		}

		$this->ucId = (isset($ucId)) ? (int) $ucId : NULL;
		$this->trackId = (isset($tid)) ? (int) $tid : NULL;
		$this->title = (isset($title)) ? $title : NULL;
		$this->description = (isset($desc)) ? $desc : NULL;
		$this->private = (isset($privacy)) ? $privacy : NULL;
		$this->flag_default = (isset($flag_default)) ? $flag_default : NULL;

		$query = "UPDATE `track` SET " .
				"title='" . $this->title . "', " .
				"description='" . $this->description . "', " .
				"private='" . $this->private . "' " .
				" WHERE id='" . $this->trackId . "' AND uc_id='" . $this->ucId . "'";

		try {
			$result = $this->sqlObj->DoQuery($query);
			$this->sqlObj->destroy();

			//force the session to reset its tracks
			if (isset($_SESSION['myTracks'])) {
				unset($_SESSION['myTracks']);
			}

			return TRUE;
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			return FALSE;
		}
	}

	/**
	 * Searches for a track based on a term that is provided by the user.
	 * @param type $term the word or phrase that will be used as part of the query to look for a track
	 * with a title that is similar to that term
	 * @param type $ucId the user id.
	 *
	 * @return type Returns the track that has been searched for.
	 */
	public function searchTrack($term, $ucId = "%") {
		$sqlObj = new DataBase();
		$query = "SELECT * FROM `track` WHERE `title` LIKE '$term' OR `description` LIKE '$term' AND `uc_id` LIKE '$ucId'";
		$sqlObj->DoQuery($query);
		$resultSet = $sqlObj->GetData();
		$sqlObj->destroy();
		return $resultSet;
	}

	/**
	 * Given the track ID, return it's friendly name.
	 * @param int $trackId The id for the track.
	 *
	 * @return string Return the friendly name.
	 */
	public function returnTrackName($trackId) {
		$sqlObj = new DataBase();
		$query = "SELECT title FROM `track` WHERE id='" . $trackId . "'";

		try {
			$sqlObj->DoQuery($query);
			$resultSet = $sqlObj->GetData();
			$sqlObj->destroy();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			return FALSE;
		}

		$trackName = (isset($resultSet[0]['title'])) ? $resultSet[0]['title'] : NULL;

		return $trackName;
	}

	/**
	 * Given the track ID, return all it's details.
	 * @param int $trackId The id for the track.
	 *
	 * @return string Return the friendly name.
	 */
	public function returnMyTrackDetails($ucId, $trackId) {
		if (!(isset($ucId) || isset($trackId))) {
			throw new MyException('Please be sure to provide the User Credential ID or Track ID.');
		}

		$sqlObj = new DataBase();
		$query = "SELECT * FROM `track` WHERE id='" . $trackId . "' AND uc_id='" . $ucId . "'";

		try {
			$sqlObj->DoQuery($query);
			$resultSet = $sqlObj->GetData();
			$sqlObj->destroy();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			return FALSE;
		}

		if (count($resultSet) > 1) {
			throw new MyException('More than one record was returned when only one should be found.');
			return FALSE;
		}

		return $resultSet;
	}

	/**
	 * Get the default track id for the user.
	 * @param int $ucId The user's credential ID.
	 *
	 * @return int Returns the default track ID.
	 */
	public function returnDefaultTrackId($ucId) {
		$this->ucId = (int) $ucId;

		$sqlObj = new DataBase();
		$query = "SELECT id FROM `track` WHERE flag_default=1 AND uc_id='" . $this->ucId . "'";

		try {
			$sqlObj->DoQuery($query);
			$resultSet = $sqlObj->GetData();
			$sqlObj->destroy();

			$trackId = (isset($resultSet[0]['id'])) ? $resultSet[0]['id'] : -1;
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
			$trackId = -1;
		}

		return $trackId;
	}

	/**
	 * Get the default track id for the user.
	 * @param int $ucId The user's credential ID.
	 *
	 * @return int Returns the default track ID or -1 if none found.
	 */
	public function createDefaultTrack($ucId) {
		$this->ucId = (int) $ucId;

		try {
			$trackId = $this->returnDefaultTrackId($this->ucId);
		} catch (MyException $e) {
			//good no default record found, so let's create a default track shall we
		}

		if ($trackId == -1) {
			try {
				$trackId = $this->createTrack($this->ucId, NULL, NULL, NULL, TRUE);
			} catch (MyException $e) {
				$e->getMyExceptionMessage();
				$trackId - 1;
			}
		}

		return $trackId;
	}

	/**
	 * Get the tracks for the given user id.
	 * IMPORTANT: This method will not return the user's default track.
	 *
	 * @param type $ucId The user's credential ID
	 * @param type $fields The specific fields that are going to be returned.
	 * @return type Return's an array of all tracks for the given ucId.
	 * @throws MyException Throws an exception if the user id is less than one.
	 */
	public function getMyTrack($ucId, $fields = NULL) {
		if ($ucId < !1) {
			throw new MyException('Sorry, you forgot to provide a user id. I cannot retrieve any tracks without it. Here\'s what you tried sending: "' . $ucId . '".');
		}

		$fields = ($fields != NULL) ? $fields : "*";
		$_resultSet = NULL;

		$ucId = (int) $ucId; //cast as into to assure no SQL injection
		$query = "SELECT {$fields} FROM `track` WHERE `uc_id`='$ucId' AND flag_default != 1 ORDER BY title ASC";

		try {
			//Construct DB object
			$sqlObj = new DataBase();

			//Execute query
			$sqlObj->DoQuery($query);

			$_resultSet = $sqlObj->GetData();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}

		$sqlObj->destroy();

		return $_resultSet;
	}

	/**
	 * Follow a track.
	 * IMPORTANT: This method will stablish a relationship with a user and a track .
	 *
	 * @param type $ucId The user's credential ID
	 * @param type $tid The Track's ID.
	 * @return type True or False.
	 * @throws MyException Throws an exception if the user id is less than one.
	 */
	public function followTrack($ucId, $tid) {

		$_resultSet = NULL;
		$_records = NULL;
		$_return = NULL;

		$ucId = (int) $ucId; //cast as into to assure no SQL injection
		$tid = (int) $tid;
		$query = "SELECT `date` FROM `track_activity` WHERE `uc_id` = $ucId AND `trck_id` = $tid";
		try {
			//Construct DB object
			$sqlObj = new DataBase();

			//Execute query
			$sqlObj->DoQuery($query);
			$_records = $sqlObj->getNumberOfRecords();
			$_resultSet = $sqlObj->GetData();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}

		$sqlObj->destroy();
		if ($_records > 0) {
			$date = $_resultSet[0]['date'];
			throw new MyException('You are already following this Track since ' . $date);
			$_return = FALSE;
		} else {
			$query = "INSERT INTO  `db_tackster`.`track_activity` (
                                `id` ,
                                `uc_id` ,
                                `trck_id` ,
                                `date`
                                )
                                VALUES (
                                        NULL ,  '$ucId',  '$tid',
                                        CURRENT_TIMESTAMP
                                );
                                ";
			try {
				//Construct DB object
				$sqlObj = new DataBase();

				//Execute query
				$sqlObj->DoQuery($query);
			} catch (MyException $e) {
				$e->getMyExceptionMessage();
			}
			$sqlObj->destroy();
			$_return = TRUE;
		}
		if (isset($_SESSION['_followingTracks']))
			unset($_SESSION['_followingTracks']); //force the cache to reset
		return $_return;
	}

	/**
	 * Get the tracks for the given user id.
	 * IMPORTANT: This method will not return the user's default track.
	 *
	 * @param type $ucId The user's credential ID
	 * @param type $fields The specific fields that are going to be returned.
	 * @return type Return's an array of all tracks for the given ucId.
	 * @throws MyException Throws an exception if the user id is less than one.
	 */
	public function returnFollowingTracks($ucId, $fields = NULL) {

		$ucId = (int) $ucId;

		if ($ucId < !1) {
			throw new MyException('Sorry, you forgot to provide a user id. I cannot retrieve any tracks without it.');
		}

		$fields = ($fields != NULL) ? $fields : "*";
		$_resultSet = NULL;

		$ucId = (int) $ucId; //cast as into to assure no SQL injection
		$query = <<<EOF
		SELECT
			ta.trck_id as id, ta.uc_id, t.keyword, t.title, t.description, t.private
		FROM
			`track` AS t,
			`track_activity` AS ta
		WHERE
			ta.`trck_id`=t.`id`
			AND t.private='F'
			AND ta.`uc_id`='{$ucId}';
EOF;

		try {
			//Execute query
			$this->sqlObj->DoQuery($query);

			$_resultSet = $this->sqlObj->GetData();
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}

		$this->sqlObj->destroy();

		return $_resultSet;
	}

	/**
	 * Deletes a track based on the trackID that is provided to the function as a parameter.
	 * @param type $trackId the track id that is going to be deleted from the database.
	 *
	 * @return boolean TRUE on successful delete.
	 */
	public function deleteTrack($trackId, $ucId) {
		$this->trackId = (int) $trackId;
		$this->ucId = (int) $ucId;

		$query = "DELETE FROM `track` WHERE `id` = '$trackId' AND `uc_id` = '$ucId'";
		try {
			$this->sqlObj->DoQuery($query);
			$this->sqlObj->destroy();
			$deleteSuccess = TRUE;

			//force the session to reset its tracks
			if (isset($_SESSION['myTracks'])) {
				unset($_SESSION['myTracks']);
			}
		} catch (MyException $e) {
			$deleteSuccess = FALSE;
			$e->getMyExceptionMessage();
		}

		return $deleteSuccess;
	}

}

?>
