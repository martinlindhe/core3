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
}
