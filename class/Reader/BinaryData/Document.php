<?php
namespace Reader\BinaryData;

class Document
{
    /**
     * Attempts to recognize binary data as a document based on signature
     * @param $data binary data
     * @return bool
     */
    public function isRecognized($data)
    {
        if ($this->isPdfData($data)) {
            return true;
        }

        return false;
    }

    public function isPdfData($data)
    {
        if (strlen($data) < 1000) {
            return false;
        }

       	if ($data[0] == '%' && $data[1] == 'P' && $data[2] == 'D' && $data[3] == 'F') {
            return true;
        }

        return false;
    }
}
