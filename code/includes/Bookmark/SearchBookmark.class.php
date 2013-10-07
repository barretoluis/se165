<?php

require_once 'Utility/MyException.class.php';
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

	public function getBookmark($word) {
		$this->keyword = $word;
		if (strlen($this->keyword) >= 1) { //let's make sure a word was even provided :)
			$query = "SELECT * FROM v_searchKeyword_sortByLikeCount WHERE keyword LIKE '%{$this->keyword}%'";
//			error_log("SQL QUERY: " . $query . "\n");

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

}

?>
