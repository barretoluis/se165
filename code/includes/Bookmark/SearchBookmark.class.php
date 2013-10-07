<?php

require_once 'DataBase.php';
require_once 'mandrillApi.php';

/*
 * Search bookmarks
 *
 * @author Jerry Phul
 */

class SearchBookmark {

	private $keyword;
	private $_words;

	/*
	 * Get keywords from the keyword table.
	 * This function will primarily be used when an end user is typing a word
	 * and we wish to autocomplete or suggest words.
	 *
	 * @param	word	Takes the word to be searched.
	 * @return	array	Returns up to 20 matching words as an array.
	 */
	public function getKeyword($word) {
		//TODO: Write function
		$this->keyword = $word;
		if(strlen($word) > 100) {	//let's make sure a word was even provided :)
//			$query = "SELECT id, keyword FROM lkup_keyword WHERE keyword LIKE '{$word}%' ORDER BY keyword ASC LIMIT 0,20;";
//
//			//Construct DB object
//			$sqlObj = new DataBase();
//
//			//Execute query
//			$this->keyword = $sqlObj->DoQuery($query);
//
//			// Destroy the DB object
//			$sqlObj->destroy();
//
//			$this->_words = $sqlObj->GetData();
		}

		return $_words;
	}

	/*
	 * Add a new word to the keyword table.
	 */
	public function addKeyword() {
		//TODO: Write function
		//		Recomend integration with Dictionary.com. Validate word and then add.

	}




}

?>
