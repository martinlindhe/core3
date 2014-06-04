<?php
namespace Client;

/**
 * Uses Swiftmailer
 */
class Mailer extends \Writer\MimeMessage
{
	private function deliver(\Swift_Message $message)
	{
		// assuming postfix or other MTA is running on localhost
		$transport = \Swift_SmtpTransport::newInstance('localhost', 25);
		$mailer = \Swift_Mailer::newInstance($transport);
		$mailer->send($message);	
	}
	
	private function getSwiftInstance()
	{
		$message = \Swift_Message::newInstance();

		$message->setSubject($this->subject);
		$message->setFrom($this->getFrom());
		$message->setTo($this->getRecipients());
		
		foreach ($this->getAttachments() as $a) {
			$attachment = \Swift_Attachment::newInstance()
				->setFilename($a->fileName)
				->setContentType($a->mimeType)
				->setBody($a->data);
			
			if ($a->contentId) {
				$attachment->getHeaders()->addTextHeader('Content-ID', $a->contentId);
			}
			$message->attach($attachment);
		}

		return $message;
	}
	
    public function send($msg)
    {
		$message = $this->getSwiftInstance();
		
		$message->setBody($msg);
		
		$this->deliver($message);
    }
	
	public function sendHtml($msg)
    {
		$message = $this->getSwiftInstance();
		$message->setBody('This is a HTML message.');

		// add html part of message
		$message->addPart($msg, 'text/html');
 
		$this->deliver($message);
    }
}
