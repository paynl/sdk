<?php


namespace Paynl\SDK\Model;

/**
 * Class Price
 * @package Paynl\SDK\Model
 *
 * @property integer $amount
 * @property string $currency
 */
class Price extends Model
{
    public function __construct()
    {
        $this->currency = 'EUR';
    }
}