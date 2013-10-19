<?php

require_once 'DataBase.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');


/** This class defines a track.
 * A track holds bookmarks/tacks.
 * This class provides functionality to create, search, delete and modify tracks
 * associated with the user account.  
 *  
 *  @author Luis
 */
class track {

	private $trackId;
	//private $boardId;
	private $ucId;
	private $title;
	private $description;
	private $private;
        
        /** This function creates a track based upon the passed array.
         *  It then passes that data, via a query, into the database.
         *  @param type $trackArray The information that applies to the track.
         */
	public function createTrack($trackArray) {
		$this->ucId = $trackArray['userId'];
		$this->title = $trackArray['title'];
		$this->description = $trackArray['desc'];
		$this->private = $trackArray['privacy'];
		$sqlObj = new DataBase();
		$query = "INSERT INTO  `db_tackster`.`track` (
                    `id` ,
                    `uc_id`,
                    `title` ,
                    `description` ,
                    `private`
                )
                VALUES (
                    NULL , '$this->ucId',  '$this->title',  '$this->description',
                    '$this->private'
                );";
		$sqlObj->DoQuery($query);
		$sqlObj->destroy();
	}
        /**
         * Searches for a track based on a term that is provided by the user.
         * @param type $term the word or phrase that will be used as part of the query to look for a track
         * with a title that is similar to that term
         * @param type $ucId the user id.
         * 
         *  @return type Returns the track that has been searched for.
         */
        
	public function searchtrack($term, $ucId = "%") {
		$sqlObj = new DataBase();
		$query = "SELECT * FROM `track` WHERE `title` LIKE '$term' OR `description` LIKE '$term' AND `uc_id` LIKE '$ucId'";
		$sqlObj->DoQuery($query);
		$resultSet = $sqlObj->GetData();
		$sqlObj->destroy();
		return $resultSet;
	}

	/**
         * Get the tracks for the given user id.
         *
         * @param type $ucId The user's credential ID
         * @param type $fields The specific fields that are going to be returned.
         * @return type Return's an array of all tracks for the given ucId.
         * @throws MyException Throws an exception if the user id is less than one. 
        */

	public function getMyTrack($ucId, $fields = NULL) 
                {
		if ($ucId < !1) {
			throw new MyException('Sorry, you forgot to provide a user id. I cannot retrieve any tracks without it. Here\'s what you tried sending: "' . $ucId . '".');
		}

		$fields = ($fields != NULL) ? $fields : "*";
		$_resultSet = NULL;

		$ucId = (int) $ucId; //cast as into to assure no SQL injection
		$query = "SELECT {$fields} FROM `track` WHERE `uc_id`='$ucId' ORDER BY title ASC";

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
         * Deletes a track based on the trackID that is provided to the function as a parameter.
 	 * @param type $trackId the track id that is going to be deleted from the database. 
         */
	public function deleteTrack($trackId) {
		$sqlObj = new DataBase();
		$query = "DELETE FROM `db_tackster`.`track` WHERE `track`.`id` = $trackId";
		$sqlObj->DoQuery($query);
		$resultSet = $sqlObj->GetData();
		$sqlObj->destroy();
	}

}

?>
