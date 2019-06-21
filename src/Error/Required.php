<?php

namespace Paynl\Error;

/**
 * Description of Error
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Required extends Error
{
    /***
     * @param string          $message
     * @param null            $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = null, \Exception $previous = null)
    {
        $message = "'$message' is required";
        parent::__construct($message, $code, $previous);
    }
}
