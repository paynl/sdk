<?php


namespace Paynl\SDK\Model;

use DateTime;

/**
 * Class Status
 * @package Paynl\SDK\Model
 *
 * @property string $code
 * @property string $name
 * @property DateTime $date
 * @property string $reason
 */
class Status extends Model
{
    public function __set($name, $value)
    {
        if ($name === 'date' && is_string($value)) {
            $value = DateTime::createFromFormat($this->getDateFormat($name), $value);
        }
        parent::__set($name, $value);
    }
}