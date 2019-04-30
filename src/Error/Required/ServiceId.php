<?php

namespace Paynl\Error\Required;

use \Paynl\Error\Required;

/**
 * Thrown when serviceId is missing
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class ServiceId extends Required
{
    public function __construct($message = null, $code = null, $previous = null)
    {
        parent::__construct('No Service id is set, use \\Paynl\\Config::setServiceId() to set the Service id');
    }
}
