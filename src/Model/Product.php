<?php


namespace Paynl\SDK\Model;


/**
 * Class Product
 * @package Paynl\SDK\Model
 *
 * @property string $id
 * @property string $description
 * @property Price $price
 * @property integer $quantity todo: This is a float
 * // todo No VAT?
 */
class Product extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->price = new Price();
    }

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