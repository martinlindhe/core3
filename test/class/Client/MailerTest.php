<?php
/**
 * @group Client
 * 
 * NOTE: in ordet to test this, setup MTA on localhost:25 and
 *       verify the recieved mails are correct
 */
class MailerTest extends \PHPUnit_Framework_TestCase
{
	private $toAddress = 'martin.lindhe@freespee.com';

	function testSendTextMail()
	{
		$msg =
			"hello world\n".
			"åäö va va va";
	
        $mailer = new \Client\Mailer();
		$mailer->setFrom('noreply@example.com');
        $mailer->addRecipient($this->toAddress);
        $mailer->setSubject('text mail åäö');
        $mailer->send($msg);
	}

    function testSendHtmlMail()
    {
        $msg = 
	 	'<html>
            <body>
                <p>utf8 test mail åäö</p> - <b>bold</b>
            </body>
            </html>
            ';

        $mailer = new \Client\Mailer();
		$mailer->setFrom('noreply@example.com');
        $mailer->addRecipient($this->toAddress);
        $mailer->setSubject('html mail åäö');
        $mailer->sendHtml($msg);
    }
	
	function testSendAttachData()
    {
        $msg = 'see attachment';

        $mailer = new \Client\Mailer();
		$mailer->setFrom('noreply@example.com');
        $mailer->addRecipient($this->toAddress);
        $mailer->setSubject('attached data mail åäö');
		
		$mailer->attachData('file content', 'file.txt', 'text/plain');
		
        $mailer->send($msg);
    }

    function testAttachAndEmbedHtmlImage()
    {
        // NOTE this shows how to embed attached image in html mail

        $mailer = new \Client\Mailer();
		$mailer->setFrom('noreply@example.com');
        $mailer->addRecipient($this->toAddress);
        $mailer->setSubject('attached embedded image mail åäö');

		$qr = new \Writer\Barcode2D\Qrcode();
        $data = $qr->renderAsPng('hello world :-)');

		$contentId = $mailer->embedData($data, 'qr.png', 'image/png');
		
		$msg =
        '<b>hello</b> world åäö!'.
        '<img src="cid:'.$contentId.'"/>';  // <- embeds attached image in the mail

		$mailer->sendHtml($msg);
    }
}
