<?php

namespace Paynl\Error;

class NotFound extends Error
{
    public function __construct($objectName, $identifier, \Exception $previous = null)
    {
        $message = "$objectName: '$identifier' Not found";
        parent::__construct($message, 404, $previous);
    }
}
