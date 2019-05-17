<?php


namespace Paynl\SDK\Model;

use DateTime;

/**
 * Class Service
 * @package Paynl\SDK\Model
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property boolean $testMode
 * @property string $secret
 * @property-read DateTime $createdAt
 * @property-read Link[] $_links
 */
class Service extends Model
{
    public function __set($name, $value)
    {
        if ($name === 'createdAt' && is_string($value)) {
            $value = DateTime::createFromFormat(DateTime::ISO8601, $value);
        }
        if ($name === 'testMode') {
            $value = (boolean)$value;
        }
        if($name === '_links' && is_array($value)){
            $this->_data[$name] = array_map(function ($link) {
                return is_array($link) ? Link::fromArray($link) : $link;
            }, $value);
            return;
        }
        parent::__set($name, $value);
    }
}