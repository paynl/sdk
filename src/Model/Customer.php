<?php


namespace Paynl\SDK\Model;

use DateTime;

/**
 * Class Customer
 * @package Paynl\SDK\Model
 *
 * @property string $initials
 * @property string $lastName
 * @property DateTime $birthDate
 * @property string $gender M or F
 * @property string $phone
 * @property string $email
 * @property integer $trustLevel Indicates whether you trust the customer, scale -10 -> 10 (10 Reliable, -10 Unreliable).
 * @property string $iban todo Why not use a bankAccount model?
 * @property string $bic
 * @property string $reference Merchants reference (id) to the customer
 * @property string $language The language code consisting of 2 uppercase letters.
 *
 */
class Customer extends Model
{
    public function __set($name, $value)
    {
        switch($name){
            case 'birthDate':
                if(is_string($value)) $value = DateTime::createFromFormat(DateTime::ISO8601, $value);
                break;
        }
        parent::__set($name, $value);
    }
}