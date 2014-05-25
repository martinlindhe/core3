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

    public function __construct()
    {
        $this->boundary = $this->createBoundary();
    }

    public function getBoundary()
    {
        return $this->boundary;
    }

    public function getRecipients()
    {
        return $this->mailRecipients;
    }

    public function setContentType($s)
    {
        $this->contentType = $s;
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

    public function setMessage($s)
    {
        $this->message = $s;
    }

    /**
     * $param $contentId used to refer to embedded graphics from html document, <img src="cid:contentId_value"/>
     */
    public function attachData($data, $fileName, $mimeType, $contentId = '')
    {
        $a = new MimeAttachment();
        $a->data      = $data;
        $a->fileName  = basename($fileName);
        $a->mimeType  = $mimeType;
        $a->contentId = $contentId;
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

    public function renderHeaders()
    {
        $headers = array(
            'MIME-Version: 1.0',
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

    public function render()
    {
        $res = $this->renderHeaders()."\r\n";

        if (count($this->attachments)) {
            $res .=
                'Content-Type: multipart/mixed; boundary="'.$this->boundary.'"'."\r\n".
                "\r\n".
                'This is a multi-part message in MIME format.'."\r\n".
                "\r\n".
                '--'.$this->boundary."\r\n";
        }

        $res .=
            $this->renderMainDocument()."\r\n".
            $this->renderAttachments();

        return $res;
    }

    protected function renderMainDocument()
    {
        return
            'Content-Type: '.$this->contentType.'; charset=utf-8'."\r\n".
            'Content-Transfer-Encoding: 7bit'."\r\n".
            "\r\n".
            $this->message;
    }

    protected function renderAttachments()
    {
        $res = '';

        foreach ($this->attachments as $a) {
            $res .=
            "\r\n".
            '--'.$this->boundary."\r\n".
            'Content-Type: '.$a->mimeType."\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            'Content-Disposition: '.($a->contentId ? 'inline' : 'attachment').
                '; filename="'.mb_encode_mimeheader($a->fileName, 'UTF-8').'"'."\r\n".
            ($a->contentId ? 'Content-ID: <'.$a->contentId.'>'."\r\n" : '').
            "\r\n".
            chunk_split(base64_encode($a->data));
        }

        if ($res) {
            $res .= '--'.$this->boundary.'--';
        }

        return $res;
    }

    protected function createBoundary()
    {
        $rnd = md5(mt_rand().microtime());
        return '------------0'.substr($rnd, 0, 23);
    }
}
