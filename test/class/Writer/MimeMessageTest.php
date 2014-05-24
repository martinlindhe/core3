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

    function testRenderTextMailHeaders()
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

        var_dump($mime->renderHeaders());

        // TODO verify that mime header keys are set
    }
}
