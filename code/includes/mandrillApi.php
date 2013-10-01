<?php
include_once 'swift_required.php';
/**
 * Description of mandrillApi
 *
 * @author Luis Barreto
 */
class mandrillApi
{
    private $subject;
    private $from;
    private $to;
    private $content;
    private $transport;
    private $swift;
    private $message;
        
    public function __construct($recipient, $sbj)// $recipient is an associative
            //array email => full name
    {
        $this->subject = $sbj;
        $this->to = $recipient;
        $this->from = array('support@tackster.com' =>'Tackster Dev Team');
        $this->transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
        $this->transport->setUsername('barretoluis@gmail.com');
        $this->transport->setPassword('Pb28jqXXpO1IAqFx-ykFXg');
        $this->swift = Swift_Mailer::newInstance($this->transport);
        
    }
        public function createEmail($htmlString)
    {
        $this->message = new Swift_Message($this->subject);
        $this->message->setFrom($this->from);
        $this->message->setBody($htmlString, 'text/html');
        $this->message->setTo($this->to);
    }
    public function sendEmail()
    {
        $status = FALSE;
        if ($recipients = $this->swift->send($this->message, $failures))
        {
            echo 'Message successfully sent!';
            $status = TRUE;
        }
        else
        {
            echo "There was an error:\n";
            $status = FALSE;
            print_r($failures);
        }
        return $status;       
    }
}
/*

$subject = 'Hello from the Dev team at Tackster!';
$from = array('support@tackster.com' =>'Dev Team');
$to = array(
 'barretoluis@gmail.com'  => 'Luis Barreto'//,
 //'recipient2@example2.com' => 'Recipient2 Name'
);

$text = "Welcome to Tackster.com this is an automated email message sent by
         our server Minions, Soon we will contact you with news";
$html = "<em>The Minions where hard at work and now give you the facility to 
         send Email notifications.<strong>HTML</strong></em>";

$transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
$transport->setUsername('barretoluis@gmail.com');
$transport->setPassword('Pb28jqXXpO1IAqFx-ykFXg');
$swift = Swift_Mailer::newInstance($transport);

$message = new Swift_Message($subject);
$message->setFrom($from);
$message->setBody($html, 'text/html');
$message->setTo($to);
$message->addPart($text, 'text/plain');

if ($recipients = $swift->send($message, $failures))
{
 echo 'Message successfully sent!';
} else {
 echo "There was an error:\n";
 print_r($failures);
}

*/


?>
