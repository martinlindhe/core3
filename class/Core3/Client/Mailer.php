<?php
namespace Core3\Client;

/**
 * Uses Swiftmailer
 */
class Mailer
{
    protected $mailFrom;
    protected $mailReplyTo;
    protected $mailRecipients = array();
    protected $mailCc = array();
    protected $mailBcc = array();
    protected $userAgent;
    protected $contentType;
    protected $subject;
    protected $message;
    protected $boundary;
    protected $attachments = array();
    protected $templatePath;

    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @return array of MailAddress objects
     */
    public function getRecipients()
    {
        return $this->mailRecipients;
    }

    protected function getMailAddressesAsArray($adr)
    {
        $res = array();
        foreach ($adr as $r) {
            if ($r->getName()) {
                $res[$r->getAddress()] = $r->getName();
            } else {
                $res[] = $r->getAddress();
            }
        }
        return $res;
    }

    /**
     * @return MailAddress
     */
    public function getFrom()
    {
        return $this->mailFrom;
    }

    /**
     * @return MailAddress
     */
    public function getReplyTo()
    {
        return $this->mailReplyTo;
    }

    public function getCc()
    {
        return $this->mailCc;
    }

    public function getBcc()
    {
        return $this->mailBcc;
    }

    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    public function setContentType($s)
    {
        $this->contentType = $s;
    }

    public function addRecipient($to, $toName = '')
    {
        if (!$this->isValidMail($to)) {
            throw new \InvalidArgumentException();
        }
        $adr = new MailAddress();
        $adr->setAddress($to);
        $adr->setName($toName);
        $this->mailRecipients[] = $adr;
    }

    public function setFrom($from, $fromName = '')
    {
        if (!$this->isValidMail($from)) {
            throw new \InvalidArgumentException();
        }
        $adr = new MailAddress();
        $adr->setAddress($from);
        $adr->setName($fromName);
        $this->mailFrom = $adr;
    }

    public function setReplyTo($replyTo, $replyToName = '')
    {
        if (!$this->isValidMail($replyTo)) {
            throw new \InvalidArgumentException();
        }
        $adr = new MailAddress();
        $adr->setAddress($replyTo);
        $adr->setName($replyToName);
        $this->mailReplyTo = $adr;
    }

    public function addCc($cc, $ccName = '')
    {
        if (!$this->isValidMail($cc)) {
            throw new \InvalidArgumentException();
        }
        $adr = new MailAddress();
        $adr->setAddress($cc);
        $adr->setName($ccName);
        $this->mailCc[] = $adr;
    }

    public function addBcc($bcc, $bccName = '')
    {
        if (!$this->isValidMail($bcc)) {
            throw new \InvalidArgumentException();
        }
        $adr = new MailAddress();
        $adr->setAddress($bcc);
        $adr->setName($bccName);
        $this->mailBcc[] = $adr;
    }

    public function setUserAgent($s)
    {
        $this->userAgent = $s;
    }

    public function setSubject($s)
    {
        $this->subject = $s;
    }

    public function setMessage($s)
    {
        $this->message = $s;
    }

    public function setTemplatePath($s)
    {
        $this->templatePath = $s;
    }

    public function isValidMail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
        return true;
    }

    /**
     * @return $contentId used to refer to embedded graphics from html document
     */
    public function embedData($data, $fileName, $mimeType)
    {
        static $contentCnt = 0;

        $contentCnt++;
        $contentId = 'content_'.$contentCnt;

        $a = new MailAttachment();
        $a->data      = $data;
        $a->fileName  = basename($fileName);
        $a->mimeType  = $mimeType;
        $a->contentId = $contentId;
        $this->attachments[] = $a;
        return $contentId;
    }

    public function attachData($data, $fileName, $mimeType)
    {
        $a = new MailAttachment();
        $a->data      = $data;
        $a->fileName  = basename($fileName);
        $a->mimeType  = $mimeType;
        $this->attachments[] = $a;
    }

    public function attachFile($fileName, $contentId = '')
    {
        if (!file_exists($fileName)) {
            throw new \FileNotFoundException($fileName);
        }

        $data = file_get_contents($fileName);

        // generic binary data
        $mimeType = 'application/octet-stream';

        $this->attachData($data, $fileName, $mimeType, $contentId);
    }

    private function deliver(\Swift_Message $message)
    {
        // we rely on exim or other MTA is running on localhost
        $transport = \Swift_SmtpTransport::newInstance('localhost', 25);
        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    private function getSwiftInstance()
    {
        $message = \Swift_Message::newInstance();

        $message->setSubject($this->subject);
        $message->setFrom($this->getFrom()->toArray());
        if ($this->getReplyTo()) {
            $message->setReplyTo($this->getReplyTo()->toArray());
        }
        $message->setTo($this->getMailAddressesAsArray($this->getRecipients()));
        $message->setCc($this->getMailAddressesAsArray($this->getCc()));
        $message->setBcc($this->getMailAddressesAsArray($this->getBcc()));

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

    /**
     * Replaces {keywords} in e-mail template
     * @param $tpl basename of template, with file extension
     */
    protected function rewriteTemplate($tpl, $variables)
    {
        $fullPath = $this->getTemplatePath().'/'.$tpl;
        if (!file_exists($fullPath)) {
            throw new \Exception('file not found');
        }

        $data = file_get_contents($fullPath);

        $search = array();
        $replace = array();
        foreach ($variables as $key => $val) {
            $search[] = '{'.$key.'}';
            $replace[] = $val;
        }

        return str_replace($search, $replace, $data);
    }

    /**
     * @param string $tpl basename of template, without file extension
     * @param array $variables
     */
    public function sendTemplate($tpl, $variables)
    {
        $bodyText = $this->rewriteTemplate($tpl.'.txt', $variables);
        $bodyHtml = $this->rewriteTemplate($tpl.'.html', $variables);

        $optionsFile = $this->getTemplatePath().'/'.$tpl.'.inc';
        if (file_exists($optionsFile)) {
            include $optionsFile;
        }

        $message = $this->getSwiftInstance();
        $message->setBody($bodyText);

        $message->addPart($bodyHtml, 'text/html');

        $this->deliver($message);
    }

    public function sendText($msg)
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
