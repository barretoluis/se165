<?php

require_once 'Utility/MyException.class.php';
require_once 'DataBase.php';
require_once 'mandrillApi.php';

/**
 * This class implements Keyword Management. It allows Keyword creation, and allows
 * querying of the database for keywords.
 *
 * @author Jerry Phul
 */

class KeywordManager {

	private $keyword;
	private $_words;

	/**
	 * Get keywords from the keyword table.
	 * This function will primarily be used when an end user is typing a word
	 * and we wish to autocomplete or suggest words.
	 *
	 * @param	word	Takes the word to be searched.
	 * @return	array	Returns up to 20 matching words as an array.
	 */
	public function getKeyword($word) {
		$this->keyword = $word;
		if (strlen($word) >= 1) { //let's make sure a word was even provided :)
			$query = "SELECT id, keyword FROM lkup_keyword WHERE keyword LIKE '{$word}%' ORDER BY keyword ASC LIMIT 0,20;";

			try {
				//Construct DB object
				$sqlObj = new DataBase();

				//Execute query
				$this->keyword = $sqlObj->DoQuery($query);
			} catch (MyException $e) {
				$e->getMyExceptionMessage();
			}

			// Destroy the DB object
			$sqlObj->destroy();

			$this->_words = $sqlObj->GetData();
		} else {
			throw new MyException('No keywords were provided for searching.');
		}

		return $this->_words;
	}

	/**
	 * Adds a new word to the keyword table.
	 * <b>NOTE: </b> Is currently not implemented.
	 *
	 * @param string $keyword The keyword to be added.
	 * @throws MyException Error returned on any unsuccessful submission.
	 * @return boolean Return TRUE on success.
	 */
	public function addKeyword($keyword) {
		//TODO: Write function
		//		Recomend integration with Dictionary.com. Validate word and then add.

		throw new MyException('Method not implemented.');

		return FALSE;
	}

}

?>
