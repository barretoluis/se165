<?php

require_once 'Utility/MyException.class.php';

class DataBase {

	private $mysqli;
	private $result;
	private $returnSet = array();

	public function __construct($h = "localhost", $u = "tackster", $p = "4tackster2use", $n = "db_tackster") {
		try {
			$this->mysqli = mysqli_connect($h, $u, $p, $n) or dbException();

			if (!$this->mysqli) {
				$mysqlErrMsg = mysqli_error($this->mysqli);
				throw new MyException("The application was unable to connect to the database to retireve information. The DB returned the following error:\n" . $mysqlErrMsg . "\n");
				echo "Unable to connect" . mysqli_error($this->mysqli);
			}
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
	}

	public function destroy() {
		$this->mysqli->close();
	}

	public function DoQuery($query) {
		$this->result = mysqli_query($this->mysqli, $query);

		if (mysqli_error($this->mysqli)) {
			throw new MyException('<p>Could not run SQL query:<br><pre>' . $query . "</pre></p><p><i>MySQL Error:</i><br>" . mysqli_error($this->mysqli) . "</p>\n");
			return NULL;
		} else {
			return mysqli_insert_id($this->mysqli);
		}
	}

	public function GetData() {
		while ($val = mysqli_fetch_assoc($this->result)) {
			array_push($this->returnSet, $val);
		}
		return $this->returnSet;
	}

	public function getNumberOfRecords() {
		return mysqli_num_rows($this->result);
	}

}

?>