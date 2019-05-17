<?php


namespace Paynl\SDK\Model;

/**
 * Class Statistics
 * @package Paynl\SDK\Model
 *
 * @property integer $promoterId todo is dit geen promotorId?
 * @property string $info
 * @property string $tool
 * @property string $extra1
 * @property string $extra2
 * @property string $extra3
 * @property array $transferData
 */
class Statistics extends Model
{
    public function __set($name, $value)
    {
        if($name==='transferData' && is_array($value)){
            // don't turn transferData into an object
            return;
        }
        parent::__set($name, $value);
    }
}