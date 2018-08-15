<?php

namespace Paynl\DirectDebit;

use Paynl\Api\DirectDebit as Api;
use Paynl\Error\Required;
use Paynl\Result\DirectDebit\Mandate as Result;

class Mandate
{
    public static function add($options)
    {
        if (empty($options['amount'])) {
            throw new Required('amount');
        }
        if (empty($options['bankaccountHolder'])) {
            throw new Required('bankaccountHolder');
        }
        if (empty($options['bankaccountNumber'])) {
            throw new Required('bankaccountNumber');
        }

        $api = new Api\MandateAdd();
        $api->setAmount(round($options['amount'] * 100));
        $api->setBankaccountHolder($options['bankaccountHolder']);
        $api->setBankaccountNumber($options['bankaccountNumber']);

        if (!empty($options['bankaccountBic'])) {
            $api->setBankaccountBic($options['bankaccountBic']);
        }
        if (!empty($options['processDate'])) {
            if (is_string($options['processDate'])) {
                $options['processDate'] = new \DateTime($options['processDate']);
            }
            $api->setProcessDate($options['processDate']);
        }
        if (!empty($options['description'])) {
            $api->setDescription($options['description']);
        }
        if (!empty($options['ipAddress'])) {
            $api->setIpAddress($options['ipAddress']);
        }
        if (!empty($options['email'])) {
            $api->setEmail($options['email']);
        }
        if (!empty($options['promotorId'])) {
            $api->setPromotorId($options['promotorId']);
        }
        if (!empty($options['tool'])) {
            $api->setTool($options['tool']);
        }
        if (!empty($options['info'])) {
            $api->setInfo($options['info']);
        }
        if (!empty($options['object'])) {
            $api->setObject($options['object']);
        }
        if (!empty($options['extra1'])) {
            $api->setExtra1($options['extra1']);
        }
        if (!empty($options['extra2'])) {
            $api->setExtra2($options['extra2']);
        }
        if (!empty($options['extra3'])) {
            $api->setExtra3($options['extra3']);
        }
        if (!empty($options['currency'])) {
            $api->setCurrency($options['currency']);
        }
        if (!empty($options['exchangeUrl'])) {
            $api->setExchangeUrl($options['exchangeUrl']);
        }
        if (!empty($options['intervalQuantity'])) {
            $api->setIntervalQuantity((int)$options['intervalQuantity']);
        }
        $result = $api->doRequest();

        return new Result\Add($result);
    }

    public static function addTransaction($options)
    {
        if (empty($options['mandateId'])) {
            throw new Required('mandateId');
        }

        $api = new Api\MandateDebit();
        $api->setMandateId($options['mandateId']);

        if (!empty($options['amount'])) {
            $api->setAmount($options['amount']);
        }
        if (!empty($options['description'])) {
            $api->setDescription($options['description']);
        }
        if (!empty($options['processDate'])) {
            if (is_string($options['processDate'])) {
                $options['processDate'] = new \DateTime($options['processDate']);
            }
            $api->setProcessDate($options['processDate']);
        }
        $result = $api->doRequest();

        return new Result\AddTransaction($result);
    }

    public static function get($mandateId)
    {
        $api = new Api\MandateGet();
        $api->setMandateId($mandateId);

        $result = $api->doRequest();
        return new Result\Get($result);
    }
}
