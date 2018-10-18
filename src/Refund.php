<?php
/*
 * Copyright (C) 2015 Andy Pieters <andy@pay.nl>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Paynl;

use Paynl\Error\Error;
use Paynl\Result\Refund as Result;

use Paynl\Api\Refund as Api;

/**
 * Description of Refund
 *
 * @author Chris de Jong <chris@eventix.io>
 */
class Refund
{

    /**
     * Start a new transaction
     *
     * @param array $options
     * @return Result\Add
     * @throws Error
     */
    public static function add(array $options = array())
    {
        $api = new Api\Add();

        if (isset($options['amount'])) {
            $api->setAmount(round($options['amount'] * 100));
        }
        if (isset($options['bankAccountHolder']) && !empty($options['bankAccountHolder'])) {
            $api->setBankAccountHolder($options['bankAccountHolder']);
        }
        if (isset($options['bankAccountNumber']) && !empty($options['bankAccountNumber'])) {
            $api->setBankAccountNumber($options['bankAccountNumber']);
        }
        if (isset($options['bankAccountBic']) && !empty($options['bankAccountBic'])) {
            $api->setBankAccountBic($options['bankAccountBic']);
        }
        if (isset($options['description']) && !empty($options['description'])) {
            $api->setDescription($options['description']);
        }
        if (isset($options['promotorId'])) {
            $api->setPromotorId($options['promotorId']);
        }
        if (isset($options['tool'])) {
            $api->setTool($options['tool']);
        }
        if (isset($options['info'])) {
            $api->setInfo($options['info']);
        }
        if (isset($options['object'])) {
            $api->setObject($options['object']);
        }
        if (isset($options['extra1'])) {
            $api->setExtra1($options['extra1']);
        }
        if (isset($options['extra2'])) {
            $api->setExtra2($options['extra2']);
        }
        if (isset($options['extra3'])) {
            $api->setExtra3($options['extra3']);
        }
        if (isset($options['orderId'])) {
            $api->setOrderId($options['orderId']);
        }
        if (isset($options['currency'])) {
            $api->setCurrency($options['currency']);
        }
        if (isset($options['processDate'])) {
            if (is_string($options['processDate'])) {
                $options['processDate'] = new \DateTime($options['processDate']);
            }
            $api->setProcessDate($options['processDate']);
        }

        $result = $api->doRequest();

        return new Result\Add($result);
    }

    /**
     * Get the refund
     *
     * @param string $refundId
     *
     * @return Result\Refund
     * @throws Error
     */
    public static function get($refundId)
    {
        $api = new Api\Info();
        $api->setRefundId($refundId);
        $result = $api->doRequest();

        $result['refundId'] = $refundId;

        return new Result\Refund($result);
    }
}
