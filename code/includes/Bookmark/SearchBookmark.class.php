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
	private $ucId;
	private $tid;
	private $privacy;
	private $_words;

	public function searchMyTrackBookmarks($word, $ucId, $tid) {
		if (!isset($word) || !is_string($word)) {
			throw new MyException('A word or a string was not provided.');
			return NULL;
		}
		if (!isset($ucId) || !is_int($ucId)) {
			throw new MyException('The User Credential was not provided as an integer or at all.');
			return NULL;
		}
		if (!isset($tid) || !is_int($tid)) {
			throw new MyException('The track ID to search is not an integer or was not set at all.');
			return NULL;
		}

		return $this->getBookmark($word, $ucId, $tid, NULL, 'timestamp');
	}

	public function searchMyBookmarks($word, $ucId) {
		if (!isset($word) || !is_string($word)) {
			throw new MyException('A word or a string was not provided.');
			return NULL;
		}
		if (!isset($ucId) || !is_int($ucId)) {
			throw new MyException('The User Credential was not provided as an integer or at all.');
			return NULL;
		}

		return $this->getBookmark($word, $ucId, NULL, NULL, 'timestamp');
	}

	public function searchPublicBookmarks($word) {
		if (!isset($word) || !is_string($word)) {
			throw new MyException('A word or a string was not provided.');
			return NULL;
		}

		return $this->getBookmark($word);
	}

	/**
	 * Get keywords from the keyword table.
	 * This function will primarily be used when an end user is typing a word
	 * and we wish to autocomplete or suggest words.
	 *
	 * @param	string	$word		Takes the word to be searched.
	 * @param	int		$ucId		The user's credential ID from the DB.
	 * @param	int		$tid		The track ID from the DB.
	 * @param	int		$privacy	0=public bookmarks while 1=private
	 * @param	string	$type		Sort by: like | timestamp
	 * @return	array	Returns up to 20 matching words as an array.
	 * @throws MyException this exception is thrown when no phrase is entered into the search.
	 * Returns an error message.
	 */
	private function getBookmark($word, $ucId = NULL, $tid = NULL, $privacy = 0, $type = "like") {
		if (!isset($word) || !is_string($word)) {
			throw new MyException('A word or a string was not provided.');
			return NULL;
		}
		$this->searchWord = $word;
		$this->ucId = (int) $ucId;
		$this->tid = (int) $tid;
		$this->privacy = (int) $privacy;

		if (strlen($this->searchWord) >= 1) { //let's make sure a word was even provided :)
			$sqlByTid = NULL;
			if ($type == "timestamp") {
				if($tid>0) {
					$sqlByTid = "AND t_id='" . $this->tid . "'";
				}
				$query = "SELECT * FROM v_searchKeyword_sortByTimestamp WHERE keyword LIKE '%{$this->searchWord}%' AND uc_id='" . $this->ucId . "' {$sqlByTid}";
			} else {
				$query = "SELECT * FROM v_searchKeyword_sortByLikeCount WHERE keyword LIKE '%{$this->searchWord}%' AND privacy='" . $this->privacy . "'";
			}

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
