<?php
namespace Core3\Reader\BinaryData;

class Image
{
    /**
     * Attempts to recognize binary data as a image based on signature
     * @param $data binary data
     * @return bool
     */
    public function isRecognized($data)
    {
        if ($this->isJpegData($data)) {
            return true;
        }

        if ($this->isPngData($data)) {
            return true;
        }

        if ($this->isGifData($data)) {
            return true;
        }

        return false;
    }

    public function isJpegData($data)
    {
        if (strlen($data) < 400) {
            return false;
        }

        if ($data[0] == chr(0xFF) && $data[1] == chr(0xD8) &&
            $data[6] == 'J' && $data[7] == 'F' && $data[8] == 'I' && $data[9] == 'F' &&
            $data[10] == chr(0)
        ) {
            return true;
        }

        return false;
    }

    public function isPngData($data)
    {
        if (strlen($data) < 30) {
            return false;
        }

        if ($data[0] == chr(0x89) &&
            $data[1] == 'P' && $data[2] == 'N' && $data[3] == 'G' &&
            $data[4] == chr(0x0D) && $data[5] == chr(0x0A) &&
            $data[6] == chr(0x1A) && $data[7] == chr(0x0A)
        ) {
            return true;
        }

        return false;
    }

    public function isGifData($data)
    {
        if (strlen($data) < 30) {
            return false;
        }

        if ($data[0] == 'G' && $data[1] == 'I' && $data[2] == 'F' &&
            $data[3] == '8' && ($data[4] == '7' || $data[4] == '9')
        ) {
            return true;
        }

        return false;
    }

}
