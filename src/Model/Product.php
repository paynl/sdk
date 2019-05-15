<?php


namespace Paynl\SDK\Model;


/**
 * Class Product
 * @package Paynl\SDK\Model
 *
 * @property string $id
 * @property string $description
 * @property Price $price
 * @property integer $quantity todo: Moet float zijn
 * // todo BTW moet hier nog bij
 */
class Product extends Model
{
    public function __set($name, $value)
    {
        switch ($name){
            case 'price':
                if(is_numeric($value)) $value = Price::fromArray(['amount' => $value]);
                elseif (is_array($value)) $value = Price::fromArray($value);
                break;
        }
        parent::__set($name, $value);
    }
}