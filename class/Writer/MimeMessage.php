<?php
namespace Writer;

// TODO finish attachment support & embedded files (html image)

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
    protected $subject;
    protected $contentType;
    protected $attachments = array();

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

    public function embedData($data, $fileName, $mimeType = '', $contentId = '')
    {
        $a = new MimeAttachment();
        $a->data      = $data;
        $a->fileName  = basename($fileName);
        $a->mimeType  = $mimeType;   // XXXX file_get_mime_by_suffix($filename)
        $a->contentId = $contentId;  // <img src="cid:content_id_tag">
        $this->attachments[] = $a;
    }

    public function embedFile($fileName, $contentId = '')
    {
        if (!file_exists($fileName)) {
            throw new \Exception ('File '.$fileName.' not found'); // XXX correct exception
        }

        $data = file_get_contents($fileName);

        $this->embedData($data, $fileName, $mimeType, $contentId);
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
        $res = $this->renderHeaders();

        if (count($this->attachments)) {
            $boundary = $this->createBoundary();

            $res .=
            "Content-Type: multipart/mixed;\r\n".
            " boundary=\"".$boundary."\"\r\n".
            "\r\n".
            "This is a multi-part message in MIME format.\r\n".
            "\r\n".
            "--".$boundary."\r\n";
        }

        $res .=
            'Content-Type: '.$this->contentType.'; charset=utf-8'."\r\n".
            'Content-Transfer-Encoding: 7bit'."\r\n".
            "\r\n";


        $attachment_data = '';
        foreach ($this->attachments as $a)
        {
            $attachment_data .=
            "\r\n".
            '--'.$boundary."\r\n".
            'Content-Type: '.$a->mimeType.';'."\r\n".
            " name=\"".mb_encode_mimeheader($a->fileName, 'UTF-8')."\"\r\n".
            'Content-Transfer-Encoding: base64'."\r\n".
            ($a->content_id ? 'Content-ID: <'.$a->content_id.'>'."\r\n" : "").
            'Content-Disposition: '.($a->content_id ? 'inline' : 'attachment').';'."\r\n".
            " filename=\"".mb_encode_mimeheader($a->filename, 'UTF-8')."\"\r\n".
            "\r\n".
            chunk_split(base64_encode($a->data));
        }

        if (count(self::$attachments))
            $attachment_data .= "--".$boundary."--";

        return $res;
        // XXX in end: $header.$msg."\r\n".$attachment_data
    }

    protected function createBoundary()
    {
        $rnd = md5(mt_rand().microtime());
        return '------------0'.substr($rnd, 0, 23);
    }
}
