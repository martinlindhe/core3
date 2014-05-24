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

        // TODO verify the mail was sent
    }
}
