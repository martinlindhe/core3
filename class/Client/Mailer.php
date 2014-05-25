<?php
namespace Client;

class Mailer extends \Writer\MimeMessage
{
    public function send($msg)
    {
        $this->setContentType('text/html');

        mail(
            implode($this->getRecipients(), ', '),
            $this->subject,
            $msg,
            $this->renderHeaders($msg)
        );
    }
}
