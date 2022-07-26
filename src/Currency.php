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

    /**
     * @param $amount Amount to convert
     * @param $targetCurrencyId Currency to convert to
     * @param int $sourceCurrencyId Currency to convert from
     * @return false|mixed Returns amount in cents of target currency or false on failure.
     */
    public static function convertAmount($amount, $targetCurrencyId, $sourceCurrencyId = 1)
    {
        try {
            $api = new Api\ConvertAmount();
            $api->setAmount($amount);
            $api->setTargetCurrencyId($targetCurrencyId);
            $api->setSourceCurrencyId($sourceCurrencyId);

            $result = $api->doRequest();
        } catch (\Exception $e) {
            $result = false;
        }

        return isset($result['result']) ? $result['result'] : false;
    }
    
}
