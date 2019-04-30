<?php

namespace Paynl\Error\Required;

use \Paynl\Error\Required;

/**
 * thrown when Apitoken is missing
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class ApiToken extends Required
{
    public function __construct($message = null, $code = null, $previous = null)
    {
        parent::__construct('No APItoken is set, use \\Paynl\\Config::setApiToken() to set the API token');
    }
}
