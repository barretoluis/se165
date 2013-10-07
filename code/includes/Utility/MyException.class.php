<?php

/*
 * Creating custom excption class to handle web pages and error logging.
 */

class MyException extends Exception {

	// Redefine the exception so message isn't optional
	public function __construct($message, $code = 0, Exception $previous = null) {
		// some code
		// make sure everything is assigned properly
		parent::__construct($message, $code, $previous);
	}

	// custom string representation of object
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}

	public function getMyExceptionMessage() {
		$err = "<div class='exception' id='exception' onClick='if(this.className == \"exceptionHide\") { document.getElementById(\"exception\").className=\"exception\"; } else { document.getElementById(\"exception\").className=\"exceptionHide\"; }'>\n";
		$err .= "<h2>Exception in Code</h2>\n";
		$err .= "<P>The application generated an Exception. For more details, also revview the error log files. NOTE: To hide this exception, click on this message box.</p>\n";
		$err .= "<b>File:</b> " . parent::getFile() . "\n";
		$err .= "<br><b>Line:</b> " . parent::getLine() . "\n";
		$err .= "<br><b>Message:</b> " . parent::getMessage() . "\n";
		$err .= "<br><b>Exception Trace:</b><br><pre>" . parent::getTraceAsString() . "</pre></div>\n";

		if (ini_get('display_errors') == 1) {
			//display errors to web page is on
			print($err);
			error_log(strip_tags($err));
		} else {
			//only send the exception to the error log
			error_log(strip_tags($err));
		}
	}

}

?>
