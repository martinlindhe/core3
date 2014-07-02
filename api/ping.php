<?php

if ($requestMethod != 'GET') {
    throw new \Exception('api request method not allowed');
}

echo \Writer\Json::encodeSlim(array('ping' => 'ok'));
