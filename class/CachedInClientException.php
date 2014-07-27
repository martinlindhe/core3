<?php

/**
 * The result of this call is cached in the client,
 * so we don't need to send the document
 */
class CachedInClientException extends \Exception
{
}
