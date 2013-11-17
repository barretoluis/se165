<?php

require_once 'Utility/MyException.class.php';
require_once 'DataBase.php';
require_once 'mandrillApi.php';

/**
 * Searches the database for bookmarks that match the phrase that is passed in the search bar.
 *
 * @author Jerry Phul
 */
class SearchBookmark {

	private $searchWord;
	private $privacy;
	private $_words;

	/**
	 * Get keywords from the keyword table.
	 * This function will primarily be used when an end user is typing a word
	 * and we wish to autocomplete or suggest words.
	 *
	 * @param	string	word		Takes the word to be searched.
	 * @param	int		$privacy	0=public bookmarks while 1=private
	 * @return	array	Returns up to 20 matching words as an array.
	 * @throws MyException this exception is thrown when no phrase is entered into the search.
	 * Returns an error message.
	 */
	public function getBookmark($word, $privacy = 0) {
		$this->searchWord = $word;
		$this->privacy = (int) $privacy;

		if (strlen($this->searchWord) >= 1) { //let's make sure a word was even provided :)
			$query = "SELECT * FROM v_searchKeyword_sortByLikeCount WHERE keyword LIKE '%{$this->searchWord}%' AND privacy='" . $this->privacy . "'";
//			error_log("SQL QUERY: " . $query . "\n");

			try {
				//Construct DB object
				$sqlObj = new DataBase();

				//Execute query
				$this->searchWord = $sqlObj->DoQuery($query);
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
