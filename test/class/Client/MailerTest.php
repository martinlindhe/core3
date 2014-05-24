<?php

/**
 * @group Client
 */
class MailerTest extends \PHPUnit_Framework_TestCase
{
    function testSend()
    {
        $msg = '
            <html>
            <body>
                <p>utf8 test mail åäö</p>
            </body>
            </html>
            ';

        $mailer = new \Client\Mailer();
        $mailer->addRecipient('martin.lindhe@freespee.com');
        $mailer->setSubject('åäö utf8 subject');
        $mailer->send($msg);
    }

    function testValidMail()
    {
        $mailer = new \Client\Mailer();
        $this->assertEquals(true, $mailer->isValidMail('user.name@sub.domain.com'));

        $this->assertEquals(false, $mailer->isValidMail('user.name'));
        $this->assertEquals(false, $mailer->isValidMail('@domain.com'));
    }

    function testRenderHtmlMailHeaders()
    {
        // TODO move to separate test file
        $header = new \Client\MimeHeaderEmail();
        $header->setContentType('text/html; charset=utf-8');
        $header->addRecipient('martin@test.com');
        $header->addCc('other@test.com');
        $header->addBcc('one@test.com');
        $header->setFrom('sender@test.com');
        $header->setReplyTo('noreply@test.com');
        $header->setUserAgent('Branded Mailer 1.0');
        $header->setSubject('åäö utf8 subject');

        var_dump( $header->renderHtmlMailHeaders() );

        // TODO verify that mime header keys are set
    }
}
