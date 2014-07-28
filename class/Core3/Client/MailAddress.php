<?php
namespace Core3\Client;

class MailAddress
{
    protected $address;
    protected $name;

    public function setAddress($s)
    {
        $this->address = $s;
    }

    public function setName($s)
    {
        $this->name = $s;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getName()
    {
        return $this->name;
    }

    public function toArray()
    {
        if ($this->name) {
            return array($this->address => $this->name);
        }

        return array($this->address);
    }
}
