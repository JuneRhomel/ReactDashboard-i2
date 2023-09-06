<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require dirname(__FILE__) . '/Exception.php';
require dirname(__FILE__) . '/PHPMailer.php';
require dirname(__FILE__) . '/SMTP.php';
class Mailer{
	private $mail;
	public function __construct($options)
	{
		$this->mail = new PHPMailer(true);
		$this->mail->SMTPDebug = $options['debug'] ?? 0; 
		$this->mail->isSMTP();
		$this->mail->Host = $options['host'] ?? 'smtp.gmail.com';
		$this->mail->SMTPAuth = true;
		$this->mail->Username = $options['username'] ?? 'intuitionnotification@gmail.com';
		$this->mail->Password = $options['password'] ?? 'aeufamxkptedqocz';
		$this->mail->SMTPSecure = $options['secure'] ?? 'ssl';
		$this->mail->Port = $options['port'] ?? 465;
		$this->mail->CharSet = 'UTF-8';
		$this->mail->Encoding = 'base64';
	}

	public function send($options)
	{
		$subject = $options['subject'];
		$body = $options['body'];
		$recipients = $options['recipients'];
		$sender_email = $options['sender_email'] ?? 'intuitionnotification@gmail.com';
		$sender_name = $options['sender_name'] ?? 'Inventi Notification';

		try {
			$this->mail->setFrom($sender_email, $sender_name);

			if(is_array($recipients))
			{
				foreach($recipients as $recipient)
				{
					$this->mail->addAddress($recipient);
				}
			}

			$this->mail->isHTML(true);
			$this->mail->Subject = $subject;
			$this->mail->Body = $body;
			$this->mail->send();
			return array('error'=>0,'description'=>'Message sent to ' . json_encode($recipients));
		} catch (Exception $e) {
			return array('error'=>1,'description'=> $this->mail->ErrorInfo);
		}
	}

	public function addAttachment($file,$name=null)
	{
		$this->mail->addAttachment($file,$name);
	}

	public function addCC($email)
	{
		$this->mail->addCC($email);
	}

	public function addBCC($email)
	{
		$this->mail->addBCC($email);
	}
	
	public function sendCalendar($calendar = [])
	{
		extract($calendar);

		try {
				$this->mail->smtpConnect(
						array(
								"ssl" => array(
										"verify_peer" => false,
										"verify_peer_name" => false,
										"allow_self_signed" => true
								)
						)
				);

				$this->mail->setFrom($sender_email, $sender_name);

				if(is_array($recipients))
				{
						foreach($recipients as $recipient)
						{
								$this->mail->addAddress($recipient);
						}
				}

				$this->mail->ContentType = 'text/calendar';
				$this->mail->Subject = $subject;
				$this->mail->isHTML(true);
				/*$this->mail->addCustomHeader('MIME-version',"1.0");
				$this->mail->addCustomHeader('Content-type',"text/calendar; method=REQUEST; charset=UTF-8");
				$this->mail->addCustomHeader('Content-Transfer-Encoding',"7bit");
				$this->mail->addCustomHeader('X-Mailer',"Microsoft Office Outlook 12.0");
				$this->mail->addCustomHeader("Content-class: urn:content-classes:calendarmessage");*/

				$ical = "BEGIN:VCALENDAR\r\n";
				$ical .= "VERSION:2.0\r\n";
				$ical .= "PRODID:-//Inventi//ITDept//EN\r\n";
				$ical .= "CALSCALE:GREGORIAN\r\n";
				$ical .= "METHOD:REQUEST\r\n";

				//$ical .= "METHOD:PUBLISH\r\n";
				$ical .= "X-WR-CALNAME:test\r\n";
				$ical .= "X-WR-TIMEZONE:Asia/Manila\r\n";

				$ical .= "BEGIN:VEVENT\r\n";
				//$ical .= "ORGANIZER;SENT-BY=\"MAILTO:{$sender_email}\":MAILTO:{$sender_email}\r\n";
				$ical .= "ORGANIZER;CN={$sender_email}:MAILTO:{$sender_email}\r\n";
				foreach($recipients as $recipient)
				{
						$ical .= "ATTENDEE;CUTYPE=INDIVIDUAL;CN={$recipient};X-NUM-GUESTS=0;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE:mailto:{$recipient}\r\n";
				}
				//$ical .= "ATTENDEE;CN={$attendee};ROLE=REQ-PARTICIPANT;PARTSTAT=ACCEPTED;RSVP=FALSE:mailto:{$attendee}\r\n";
				$ical .= "UID:".strtoupper(md5($event_id))."@inventi.ph\r\n";
				$ical .= "SEQUENCE:".$sequence."\r\n";
				$ical .= "STATUS:".$status."\r\n";
				//$ical .= "DTSTAMPTZID=Asia/Manila:".date('Ymd').'T'.date('His')."\r\n";
				$ical .= "DTSTAMP:". date('Ymd')  . 'T' . date('His') ."Z\r\n";
				$ical .= "DTSTART:".$start."T".$start_time."\r\n";
				$ical .= "DTEND:".$end."T".$end_time."\r\n";
				$ical .= "LOCATION:".$venue."\r\n";
				$ical .= "SUMMARY:".$summary."\r\n";
				$ical .= "DESCRIPTION:".$description."\r\n";
				//$ical .= "URL:https://calendar.google.com/calendar/embed?src=c_4uijunggfq12lusmmkeu58u93k%40group.calendar.google.com&ctz=Asia%2FManila\r\n";
				//$ical .= "BEGIN:VALARM\r\n";
				//$ical .= "TRIGGER:-PT15M\r\n";
				//$ical .= "ACTION:DISPLAY\r\n";
				//$ical .= "DESCRIPTION:Reminder\r\n";
				//$ical .= "END:VALARM\r\n";
				$ical .= "END:VEVENT\r\n";
				$ical .= "END:VCALENDAR\r\n";

				$this->mail->Body = "<b>{$summary}</b><p>{$description}</p>";
				//$this->mail->Body = $ical;
				$this->mail->addStringAttachment($ical,'invite.ics','base64','text/calendar');
				$this->mail->addStringAttachment($ical,'Mail Attachment.ics','base64','text/calendar');
				if(!$this->mail->send())
				{
						echo "Mailer Error: " . $this->mail->ErrorInfo;
				}
				return array('error'=>0,'description'=>'Message sent');
		} catch (Exception $e) {
				return array('error'=>1,'description'=> $this->mail->ErrorInfo);
		}
	}
}
