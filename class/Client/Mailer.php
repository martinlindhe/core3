<?php
namespace Client;

// STATUS: incomplete TODO finish attachment support

// TODO install the PEAR::Mail_Mime instead, or similar in composer!
// TODO handle email attachments & embedded files (html image)
// TODO make a MimeHeaderEmail  class, (and a MimeHeaderHttp ?)

class MimeHeaderEmail
{
    protected $mailFrom;
    protected $mailReplyTo;
    protected $mailRecipients = array();
    protected $mailCc = array();
    protected $mailBcc = array();
    protected $userAgent;
    protected $subject;
    protected $contentType;

    public function getMailRecipients()
    {
        return $this->mailRecipients;
    }

    public function setContentType($s)
    {
        $this->contentType =  $s;
    }

    public function addRecipient($to)
    {
        if (!$this->isValidMail($to)) {
            throw new Exception('TODO');
        }
        $this->mailRecipients[] = $to;
    }

    public function setFrom($from)
    {
        if (!$this->isValidMail($from)) {
            throw new Exception('TODO');
        }
        $this->mailFrom = $from;
    }

    public function setReplyTo($replyTo)
    {
        if (!$this->isValidMail($replyTo)) {
            throw new Exception('TODO');
        }
        $this->mailReplyTo = $replyTo;
    }

    public function addCc($cc)
    {
        if (!$this->isValidMail($cc)) {
            throw new Exception('TODO');
        }
        $this->mailCc[] = $cc;
    }

    public function addBcc($bcc)
    {
        if (!$this->isValidMail($bcc)) {
            throw new Exception('TODO');
        }
        $this->mailBcc[] = $bcc;
    }

    public function setUserAgent($s)
    {
        $this->userAgent = $s;
    }

    public function setSubject($s)
    {
        $this->subject = $s;
    }

    public function isValidMail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
        return true;
    }

    public function renderHtmlMailHeaders()
    {
        $headers = array(
            'MIME-Version: 1.0',
            'Content-Type: '.$this->contentType.'; charset=utf-8',
            'Content-Transfer-Encoding: 7bit',    // XXX is this required?
            'Subject: '.mb_encode_mimeheader($this->subject, 'UTF-8'),
            'Date: '.date('r'), // r = RFC 2822 formatted date
            'To: '.implode($this->mailRecipients, ', ')
        );

        if ($this->mailFrom) {
            $headers[] = 'From: '.$this->mailFrom;
        }
        if (count($this->mailCc)) {
            $headers[] = 'Cc: '.implode($this->mailCc, ', ');
        }
        if (count($this->mailBcc)) {
            $headers[] = 'Bcc: '.implode($this->mailBcc, ', ');
        }
        if ($this->mailReplyTo) {
            $headers[] = 'Reply-To: '.$this->mailReplyTo;
        }
        if ($this->userAgent) {
            $headers[] = 'User-Agent: '.$this->userAgent;
        }

        return implode("\r\n", $headers);
    }
}

class Mailer extends MimeHeaderEmail
{
    public function send($msg)
    {
        $this->setContentType('text/html');

        $to = implode($this->getMailRecipients(), ', ');

        $headers = $this->renderHtmlMailHeaders($msg);

        // FIXME TODO can we skip the $to param since we added it in headers?
        mail($to, $this->subject, $msg, $headers);
    }
}
