<?php
namespace Client;

class Mailer extends \Writer\MimeMessage
{
    public function send($msg)
    {
        $this->setContentType('text/html');

        mail(
            implode($this->getRecipients(), ', '),  // FIXME can we skip the $to param since we added it in headers?
            $this->subject,
            $msg,
            $this->renderHeaders($msg)
        );
    }
}
