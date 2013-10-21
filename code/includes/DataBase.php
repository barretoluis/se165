<?php

require_once 'Utility/MyException.class.php';

/** This class handles Database interactions, such as constructing a new
 *  connection, and allows related functions.
 *
 * @author Luis Barreto
 */
class DataBase {

	private $mysqli;
	private $result;
	private $returnSet = array();

	/** This is the constructer that creates the connection.
	 *
	 * @param type $h The name of the host.
	 * @param type $u The user name to access the database.
	 * @param type $p The password associated with the user.
	 * @param type $n The name of the database.
	 *
	 * @throws MyException The exception that is thrown in case of an error.
	 */
	public function __construct($h = "localhost", $u = "tackster", $p = "4tackster2use", $n = "db_tackster") {
		try {
			$this->mysqli = mysqli_connect($h, $u, $p, $n) or dbException();

			if (!$this->mysqli) {
				$mysqlErrMsg = mysqli_error($this->mysqli) or trigger_error("");
				throw new MyException("The application was unable to connect to the database to retireve information. The DB returned the following error:\n" . $mysqlErrMsg . "\n");
				echo "Unable to connect" . mysqli_error($this->mysqli);
			}
		} catch (MyException $e) {
			$e->getMyExceptionMessage();
		}
	}

	/**
	 * This function ends the current connection to the databse.
	 */
	public function destroy() {
		$this->mysqli->close();
	}

	/**
	 * Calls the mysqli_query function to retrieve data based on the query
	 * parameter paseed to the function.
	 * @param type $query the query that is going to be run against the database.
	 * @return the query information, or NULL if an exception is thrown
	 * @throws MyException when there is an error a string message is
	 * displayed saying the query could not be completed.
	 */
	public function DoQuery($query) {
		$this->result = mysqli_query($this->mysqli, $query) or trigger_error("");

		if (mysqli_error($this->mysqli)) {
			throw new MyException('<p>Could not run SQL query:<br><pre>' . $query . "</pre></p><p><i>MySQL Error:</i><br>" . mysqli_error($this->mysqli) . "</p>\n");
			return NULL;
		} else {
			return mysqli_insert_id($this->mysqli);
		}
	}

	/**
	 * Gets the data that is returned by the result set from the database query.
	 * @return type the array holding all of the data
	 */
	public function GetData() {
		while ($val = mysqli_fetch_assoc($this->result)) {
			array_push($this->returnSet, $val);
		}
		return $this->returnSet;
	}

	/**
	 * Returns the number of rows that is returned by the result set
	 *  retrieved from the database.
	 * @return type the number of rows returned by the result set.
	 */
	public function getNumberOfRecords() {
		return mysqli_num_rows($this->result);
	}

}

?>