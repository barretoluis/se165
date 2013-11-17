<?php

require_once 'DataBase.php';

/**
 * Global settings and functions, such as disabling magic quotes
 * and removing backslashes and forward slashes.
 *
 * @author Jerry Phul
 */
class EnvUtilities {

	/**
	 * Disables all the effects from magic quotes. Regardless of magic quotes being enabled,
	 * this function will override the PHP setting. This method will clean all RESPONSEs to
	 * the web server for SQL, HTML, XSS, etc. injection.
	 *
	 * <p><b>Note:</b> When using data from POST, GET or COOKIE, be sure to unescape
	 * your data.</p>
	 *
	 */
	public function disable_magic_quotes() {
		//let's turn off magic quotes - just a bunch of pain anyway
		@set_magic_quotes_runtime(false);
		ini_set('magic_quotes_runtime', 0);

		/**
		 * Removes malicious data from string. Primarily used to clean XSS and
		 * other vulnerabilities.
		 * @param string $input The string to be cleaned.
		 * @return string
		 */
		function cleanString(&$string) {
			if (is_array($string)) {
				foreach ($string as $key => &$value) {
					cleanString($value);
				}
			} else {
				$string = strip_tags($string);
				$string = htmlspecialchars($string, 4, 'UTF-8');
				$string = htmlentities($string);
				$string = stripslashes($string);

				$mysqliLink = new mysqli("localhost", "tackster", "4tackster2use", "db_tackster");
//			error_log("SQL INJECTION BEFORE: " . $string . "\n", 3, "/tmp/php_error.log");
				$string = mysqli_real_escape_string($mysqliLink, $string);
//			error_log("SQL INJECTION AFTER: " . $string . "\n", 3, "/tmp/php_error.log");
			}
		}

		array_walk($_POST, 'cleanString');
		array_walk($_GET, 'cleanString');
		array_walk($_COOKIE, 'cleanString');
	}

	/**
	 * Prints out the string with the slashes removed.
	 *
	 * @param type $escapedString The string that will have its slashes removed.
	 */
	function print_formData($escapedString) {
		$escapedString = stripcslashes($escapedString);

		echo $escapedString;
	}

}

/**
 * Protects against SQL Injection by getting rid of backslashes. Use this method
 * when displaying data on the web page. This should override all 'echo' mentions
 * in the front-end pages.
 *
 * @param type $escapedString The string that has been input.
 */
function echo_formData($escapedString) {
	$es = new EnvUtilities;
	$es->print_formData($escapedString);
}

?>
