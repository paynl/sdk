<?php


namespace Paynl\SDK\Model;

/**
 * Class Address
 * @package Paynl\SDK\Model
 *
 * @property string $initials
 * @property string $lastName
 * @property string $streetName
 * @property string $streetNumber
 * @property string $streetNumberExtension
 * @property string $zipCode
 * @property string $city
 * @property string $regionCode
 * @property string $countryCode
 */
class Address extends Model
{
    public function __construct()
    {
        // todo: Remove when api is fixed
        $this->streetNumberExtension = 'A';
    }
}