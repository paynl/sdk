<?php
/**
 * Created by PhpStorm.
 * User: andy
 * Date: 6-7-16
 * Time: 17:59
 */

namespace Paynl;


use Paynl\Api\Currency as Api;
use Paynl\Error\NotFound;

class Currency
{
    private static $_allCurrencies;

    /**
     * @return array All supported currencies
     */
    public static function getAll(){
        if(empty(self::$_allCurrencies)){
            $api = new Api\GetAll();

            self::$_allCurrencies = $api->doRequest();
        }

        return self::$_allCurrencies;
    }

    /**
     * Get the currencyId for a currency
     *
     * @param $isoCode
     * @return int
     * @throws NotFound
     */
    public static function getCurrencyId($isoCode){
        $allCurrencies = self::getAll();

        foreach($allCurrencies as $currency){
            if(strtoupper($currency['abbreviation']) == strtoupper($isoCode)){
                return $currency['id'];
            }
        }
        throw new NotFound('Currency', $isoCode);
    }
}