<?php
require_once 'Utility/MyException.class.php';
include_once 'swift_required.php';

/**
 * Description of mandrillApi.
 * Mandrill is a third party application that automatically sends email in
 * response to certain triggers. The application also allows you to track
 * data on these emails to gain insights into the emails that have been sent.
 *
 * @author Luis Barreto
 */
class mandrillApi {

	private $subject;
	private $from;
	private $to;
	private $content;
	private $transport;
	private $swift;
	private $message;

	/**
	 * This creates the Application with the recipient and the subject of
	 * the message.
	 * @param type $recipient The address that will receive the email.
	 * @param type $sbj The subject of the message.
	 */
	public function __construct($recipient, $sbj) {
		$this->subject = $sbj;
		$this->to = $recipient;
		$this->from = array('support@tackster.com' => 'Tackster Dev Team');
		$this->transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
		$this->transport->setUsername('barretoluis@gmail.com');
		$this->transport->setPassword('Pb28jqXXpO1IAqFx-ykFXg');
		$this->swift = Swift_Mailer::newInstance($this->transport);
	}

	/**
	 * Creates an e-mail message by setting the message data to the
	 * information stored in this class.
	 * @param type $htmlString the body of the e-mail that will be sent.
	 */
	public function createEmail($htmlString) {
		$emailHead = @file_get_contents('html/emailHeader.php', TRUE);
		$emailFoot = @file_get_contents('html/emailFooter.php', TRUE);

		$htmlString = $emailHead . $htmlString . $emailFoot;

		$this->message = new Swift_Message($this->subject);
		$this->message->setFrom($this->from);
		$this->message->setBody($htmlString, 'text/html');
		$this->message->setTo($this->to);
	}

	/**
	 * Attempts to send an e-mail to the recipients, if successful then print
	 * out a message and set the status to true. If there was an error, set the
	 * status to false and print the failures.
	 * @return type $status the status of whether or not the e-mail was sent correctly or not.
	 * @param type $htmlString
	 */
	public function sendEmail() {
		$status = FALSE;
		if ($recipients = $this->swift->send($this->message, $failures)) {
			$status = TRUE;
		} else {
			throw new MyException('There was an error sending the email.');
			$status = FALSE;
//			print_r($failures);
		}
		return $status;
	}

}

?>
