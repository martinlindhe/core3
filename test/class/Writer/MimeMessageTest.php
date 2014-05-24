<?php

// TODO use the Mailparse PECL to verify content?

/**
 * @group Writer
 */
class MimeMessageTest extends \PHPUnit_Framework_TestCase
{
    function testValidMail()
    {
        $mime = new \Writer\MimeMessage();
        $this->assertEquals(true, $mime->isValidMail('user.name@sub.domain.com'));

        $this->assertEquals(false, $mime->isValidMail('user.name'));
        $this->assertEquals(false, $mime->isValidMail('@domain.com'));
    }

    function testSimple()
    {
        $mime = new \Writer\MimeMessage();
        $mime->setContentType('text/plan');
        $mime->addRecipient('martin@test.com');
        $mime->addCc('other@test.com');
        $mime->addBcc('one@test.com');
        $mime->setFrom('sender@test.com');
        $mime->setReplyTo('noreply@test.com');
        $mime->setUserAgent('Branded Mailer 1.0');
        $mime->setSubject('åäö utf8 subject');
        $mime->setMessage('<b>hello</b> world åäö!');

   //     var_dump($mime->render());

        // TODO verify resulting mime message
    }

    function testAttachData()
    {
        // NOTE this shows how to embed attached image in html mail
        $mime = new \Writer\MimeMessage();
        $mime->setContentType('text/plan');
        $mime->addRecipient('martin@test.com');
        $mime->addCc('other@test.com');
        $mime->addBcc('one@test.com');
        $mime->setFrom('sender@test.com');
        $mime->setReplyTo('noreply@test.com');
        $mime->setUserAgent('Branded Mailer 1.0');
        $mime->setSubject('åäö utf8 subject');

        $html =
        '<b>hello</b> world åäö!'.
        '<img src="cid:qrcode"/>';  // <- embeds attached image in the mail
        $mime->setMessage($html);

        $qr = new \Writer\Barcode2D\Qrcode();
        $data = $qr->renderAsPng('hello world :-)');
        $mime->attachData($data, 'qr.png', 'image/png', 'qrcode');

        $this->assertGreaterThanOrEqual(20, strlen($mime->getBoundary()));

        echo $mime->render();

        // TODO verify resulting mime message
    }

}
