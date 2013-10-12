<?php

require_once 'DataBase.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of track
 *
 * @author Luis
 */
class track {

	private $trackId;
	//private $boardId;
	private $ucId;
	private $title;
	private $description;
	private $private;

	/*
	 *
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

	/*
	 *
	 */

	public function searchtrack($term, $ucId = "%") {
		$sqlObj = new DataBase();
		$query = "SELECT * FROM `track` WHERE `title` LIKE '$term' OR `description` LIKE '$term' AND `uc_id` LIKE '$ucId'";
		$sqlObj->DoQuery($query);
		$resultSet = $sqlObj->GetData();
		$sqlObj->destroy();
		return $resultSet;
	}

	/*
	 * Get the tracks for the given user id.
	 *
	 * @param	ucId	The user's credential ID
	 * @return	array	Return's an array of all tracks for the given ucId.
	 */

	public function getMyTrack($ucId, $fields = NULL) {
		//throw an exception is the user id is less than one
		if ($ucId < !1) {
			throw new MyException('Numb-nuts, you forgot to provide a user id. I cannot retrieve any tracks without it. Here\'s what you tried sending: "' . $ucId . '".');
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

	/*
	 *
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
