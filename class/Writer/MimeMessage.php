<?php
namespace Writer;

class MimeAttachment
{
    var $data;
    var $fileName;
    var $mimeType;
    var $contentId; ///< for embedded images
}


class MimeMessage
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

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function getRecipients()
    {
        return $this->mailRecipients;
    }

    public function getFrom()
    {
        return $this->mailFrom;
    }

    public function setContentType($s)
    {
        $this->contentType = $s;
    }

    public function addRecipient($to)
    {
        if (!$this->isValidMail($to)) {
            throw new \InvalidArgumentException();
        }
        $this->mailRecipients[] = $to;
    }

    public function setFrom($from)
    {
        if (!$this->isValidMail($from)) {
            throw new \InvalidArgumentException();
        }
        $this->mailFrom = $from;
    }

    public function setReplyTo($replyTo)
    {
        if (!$this->isValidMail($replyTo)) {
            throw new \InvalidArgumentException();
        }
        $this->mailReplyTo = $replyTo;
    }

    public function addCc($cc)
    {
        if (!$this->isValidMail($cc)) {
            throw new \InvalidArgumentException();
        }
        $this->mailCc[] = $cc;
    }

    public function addBcc($bcc)
    {
        if (!$this->isValidMail($bcc)) {
            throw new \InvalidArgumentException();
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

    public function setMessage($s)
    {
        $this->message = $s;
    }

    /**
	 * @return $contentId used to refer to embedded graphics from html document
     */
    public function embedData($data, $fileName, $mimeType)
    {
        static $contentCnt = 0;

        $contentCnt++;
        $contentId = 'content_'.$contentCnt;

        $a = new MimeAttachment();
        $a->data      = $data;
        $a->fileName  = basename($fileName);
        $a->mimeType  = $mimeType;
        $a->contentId = $contentId;
        $this->attachments[] = $a;
        return $contentId;
    }

    public function attachData($data, $fileName, $mimeType)
    {
        $a = new MimeAttachment();
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

        $mimeType = 'application/octet-stream'; // generic binary data

        $this->attachData($data, $fileName, $mimeType, $contentId);
    }

    public function isValidMail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
        return true;
    }
}
