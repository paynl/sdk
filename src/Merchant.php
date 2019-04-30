<?php

namespace Paynl;

use \Paynl\Api\Merchant as Api;
use Paynl\Error\Error;

class Merchant
{

    /**
     * @param $tradeName
     *
     * @return string The id of the tradename
     */
    public static function addTradeName($tradeName)
    {
        $api = new Api\AddTrademark();
        $api->setTrademark($tradeName);
        $result = $api->doRequest();
        if (!isset($result['result'])) {
            throw new Error('Unexpected response');
        }
        return $result['result'];
    }

    /**
     * @param $tradeNameId
     *
     * @return bool
     */
    public static function deleteTradeName($tradeNameId)
    {
        $api= new Api\DeleteTrademark();

        $api->setTrademarkId($tradeNameId);

        $result = $api->doRequest();

        if (!isset($result['result'])) {
            throw new Error('Unexpected response');
        }
        return $result['result'] == true;
    }

    /**
     * @param null $merchantId
     *
     * @return Result\Merchant\Info
     */
    public static function info($merchantId = null)
    {
        $api = new Api\Info();

        if ($merchantId !== null) {
            $api->setMerchantId($merchantId);
        }

        $result = $api->doRequest();

        return new Result\Merchant\Info($result);
    }


    /**
     * @param null $merchantId
     *
     * @return array
     */
    public static function getTradeNames($merchantId = null)
    {
        return self::info($merchantId)->getTradeNames();
    }
}
