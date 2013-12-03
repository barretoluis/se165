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
	private $_tid = array();
	private $privacy;
	private $_words;

	public function searchMyTrackBookmarks($word, $ucId, $_tid) {
		if (!isset($word) || !is_string($word)) {
			throw new MyException('A word or a string was not provided.');
			return NULL;
		}
		if (!isset($ucId) || !is_int($ucId)) {
			throw new MyException('The User Credential was not provided as an integer or at all.');
			return NULL;
		}
		if (!isset($_tid) || !is_array($_tid)) {
			throw new MyException('The track ID to search is not an integer in an array or was not set at all.' . json_encode($_tid));
			return NULL;
		}

		return $this->getBookmark($word, $ucId, $_tid, NULL, 'timestamp');
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
	 * @param	int[]	$_tid		The array of track IDs from the DB. -1 for public and 0 for user's tracks
	 * @param	int		$privacy	0=public bookmarks while 1=private
	 * @param	string	$type		Sort by: like | timestamp
	 * @return	array	Returns up to 20 matching words as an array.
	 * @throws MyException this exception is thrown when no phrase is entered into the search.
	 * Returns an error message.
	 */
	private function getBookmark($word, $ucId = NULL, $_tid = NULL, $privacy = 0, $type = "like") {
		if (!isset($word) || !is_string($word)) {
			throw new MyException('A word or a string was not provided.');
			return NULL;
		}
		$this->searchWord = $word;
		$this->ucId = (int) $ucId;
		$this->_tid = $_tid;
		$this->privacy = (int) $privacy;

		if (strlen($this->searchWord) >= 1) { //let's make sure a word was even provided :)
			$sqlByTid = NULL;
			if ($type == "timestamp") {
				if (count($_tid) > 0) {
					$delimiter = NULL;
					foreach ($_tid as $value) {
						$value = (int) $value;
						if ($value == -1) {
							goto searchPublicQuery;
						} else {
							$sqlByTid .= "{$delimiter} t_id='" . $value . "' ";
						}
						$delimiter = " OR ";
					}
					$sqlByTid = " AND (" . $sqlByTid . ")";
				}
				$query = "SELECT * FROM v_searchKeyword_sortByTimestamp WHERE keyword LIKE '%{$this->searchWord}%' AND uc_id='" . $this->ucId . "' {$sqlByTid}";
//				throw new MyException($query);	//debugging
			} else {
				searchPublicQuery:
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
