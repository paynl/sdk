<?php


namespace Paynl\SDK\Exception;


use Throwable;

class UnprocessableException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);


        $this->message = json_encode(json_decode($message)->errors, JSON_PRETTY_PRINT);
    }

}