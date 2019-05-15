<?php


namespace Paynl\SDK\Model;

use DateTime;

/**
 * Class Merchant
 * @package Paynl\SDK\Model
 *
 * @property string $id
 * @property string $name
 * @property string $coc Chamber of commerce registration number
 * @property string $vat VAT identification number
 * @property string $website
 * @property BankAccount $bankAccount
 * @property Address $postalAddress
 * @property Address $visitAddress
 * @property TradeName[] $tradeNames
 * @property ContactMethod[] $contactMethods
 * @property DateTime $createdAt
 */
class Merchant extends Model
{
    public function __set($name, $value)
    {
        switch ($name) {
            case 'createdAt':
                if (is_string($value)) $value = DateTime::createFromFormat(DateTime::ISO8601, $value);
                break;
        }
        if (is_array($value)) {
            switch ($name) {
                case 'bankAccount':
                    $value = BankAccount::fromArray($value);
                    break;
                case 'visitAddress':
                case 'postalAddress':
                    $value = Address::fromArray($value);
                    break;
                case 'tradeNames':
                    $this->_data[$name] = array_map(function ($tradeName) {
                        return is_array($tradeName) ? TradeName::fromArray($tradeName) : $tradeName;
                    }, $value);
                    return;
                    break;
                case 'contactMethods':
                    $this->_data[$name] = array_map(function ($contactMethod) {
                        return is_array($contactMethod) ? ContactMethod::fromArray($contactMethod) : $contactMethod;
                    }, $value);
                    return;
                    break;

            }
        }
        parent::__set($name, $value);
    }
}