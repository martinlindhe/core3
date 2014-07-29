<?php

class Ping
{
    public function handleGet()
    {
        echo \Core3\Writer\Json::encodeSlim(array('ping' => 'ok'));
    }
}
