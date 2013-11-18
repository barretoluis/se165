<?php

/**
 * Creating custom excption class to handle web pages and error logging.
 * This class extends Exception, so that it is an exception.
 *
 * @author Jerry Phul
 */

class MyException extends Exception {

	/** 
         * This function constructs a MyException object by calling the
         * parent construct function.
         * @param type $message The passsed message
         * @param type $code Is 0 by default.
         * @param Exception $previous
         */
	public function __construct($message, $code = 0, Exception $previous = null)
        {
		parent::__construct($message, $code, $previous);
	}

	/** This function returns the Exception in a string format.
         * @return type The Exception in string format.
         */
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
        /** This function displays the error message from this exception
         *  by appending it to the current webpage.
         */
	public function getMyExceptionMessage() {
		$timestamp = strtotime("now");
                //$timestamp = ""; //strtotime doesn't work on our local machine.
		sleep(1);
		$err = "<div class='exception' id='exception_{$timestamp}'
				onClick='if(this.className == \"exceptionHide\") {
							document.getElementById(\"exception_{$timestamp}\").className=\"exception\";
						} else {
							document.getElementById(\"exception_{$timestamp}\").className=\"exceptionHide\"; }'>\n";
		$err .= "<h2>Exception in Code</h2>\n";
		$err .= "<P>The application generated an Exception. For more details, also review the error log files.
				NOTE: To hide this exception, click on this message box.</p>\n";
		$err .= "<b>File:</b> " . parent::getFile() . "\n";
		$err .= "<br><b>Line:</b> " . parent::getLine() . "\n";
		$err .= "<br><b>Message:</b> " . parent::getMessage() . "\n";
		$err .= "<br><b>Exception Trace:</b><br><pre>" . parent::getTraceAsString() . "</pre></div>\n";


		if (ini_get('display_errors') == 1 || ini_get('display_errors') == 'On') {
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
