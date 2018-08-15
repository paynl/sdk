<?php

namespace Paynl;

use Paynl\Api\Currency as Api;
use Paynl\Error\NotFound;

class Currency
{
    private static $_allCurrencies;

    /**
     * @return array All supported currencies
     */
    public static function getAll()
    {
        if (empty(self::$_allCurrencies)) {
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
    public static function getCurrencyId($isoCode)
    {
        $allCurrencies = self::getAll();

        foreach ($allCurrencies as $currency) {
            if (strcasecmp($currency['abbreviation'], $isoCode) === 0) {
                return $currency['id'];
            }
        }
        throw new NotFound('Currency', $isoCode);
    }
}
