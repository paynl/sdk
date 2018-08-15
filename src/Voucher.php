<?php

namespace Paynl;

use Paynl\Api\Voucher as Api;
use Paynl\Result\Voucher as Result;

class Voucher
{
    /**
     * Return the voucher
     *
     * @param string $cardNumber
     * @return Result\Voucher
     */
    public static function get($cardNumber)
    {
        $api = new Api\Balance();
        $api->setCardNumber($cardNumber);
        $result = $api->doRequest();

        return new Result\Voucher($result);
    }

    /**
     * Return the voucher
     *
     * @param array $options
     * @return float the current balance
     */
    public static function balance(array $options = array())
    {
        $api = new Api\Balance();

        if (isset($options['cardNumber'])) {
            $api->setCardNumber($options['cardNumber']);
        }
        if (isset($options['pincode'])) {
            $api->setPincode($options['pincode']);
        }
        $result = $api->doRequest();

        return $result['balance'] / 100;
    }

    /**
     * Charge a voucher
     * @param array $options
     * @return bool if the charge was done succefully
     */
    public static function charge(array $options = array())
    {
        $api = new Api\Charge();

        if (isset($options['pincode'])) {
            $api->setPincode($options['pincode']);
        }
        if (isset($options['cardNumber'])) {
            $api->setCardNumber($options['cardNumber']);
        }
        if (isset($options['amount'])) {
            $api->setAmount(round($options['amount'] * 100));
        }
        $result = $api->doRequest();

        return $result['request']['result'] == 1;
    }

    /**
     * @param array $options
     * @return bool
     */
    public static function activate(array $options = array())
    {
        $api = new Api\Activate();

        if (isset($options['pincode'])) {
            $api->setPincode($options['pincode']);
        }
        if (isset($options['cardNumber'])) {
            $api->setCardNumber($options['cardNumber']);
        }
        if (isset($options['amount'])) {
            $api->setAmount(round($options['amount'] * 100));
        }
        if (isset($options['posId'])) {
            $api->setPosId($options['posId']);
        }
        $result = $api->doRequest();

        return $result['request']['result'] == 1;
    }
}
