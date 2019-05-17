<?php


namespace Paynl\SDK\Model;

use DateTime;

/**
 * Class Status
 * @package Paynl\SDK\Model
 *
 * @property-read string $code
 * @property-read string $name
 * @property-read DateTime $date
 * @property-read string $reason
 */
class Status extends Model
{
    public function __set($name, $value)
    {
        if ($name === 'date' && is_string($value)) {
            $value = DateTime::createFromFormat(DateTime::ISO8601, $value);
        }
        parent::__set($name, $value);
    }
}