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

use Paynl\Api\Instore as Api;
use Paynl\Result\Instore as Result;

/**
 * Description of Transaction
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Instore
{
    /**
     * Get the status for an instore payment
     *
     * @param array $options
     * @return Result\Status
     */
    public static function status($options)
    {
        $api = new Api\Status();

        if (isset($options['hash'])) {
            $api->setHash($options['hash']);
        }

        $result = $api->doRequest();

        return new Result\Status($result);
    }

    /**
     * Get all terminals linked to the service
     *
     * @return Result\Terminals
     */
    public static function getAllTerminals()
    {
        $api = new Api\GetAllTerminals();

        $result = $api->doRequest();

        return new Result\Terminals($result);
    }

    /**
     * Send the payment to a terminal
     *
     * @param array $options
     *
     * @return Result\Payment
     */
    public static function payment($options)
    {
        $api = new Api\Payment();

        if (isset($options['transactionId'])) {
            $api->setTransactionId($options['transactionId']);
        }
        if (isset($options['terminalId'])) {
            $api->setTerminalId($options['terminalId']);
        }

        $result = $api->doRequest();
        return new Result\Payment($result);
    }

    /**
     * Confirm the payment, and send the receipt
     *
     * ['hash'] string the hash of the transaction
     * ['emailAddress'] string the emailaddress to send the receipt to
     * ['languageId'] int the languageId
     *                  1. Dutch
     *                  2. Flemish
     *                  4. English
     *                  5. German
     *                  6. French
     *                  8. Spanish
     *                  9. Italian
     *
     * @param array $options (See above)
     * @return Result\ConfirmPayment
     */
    public static function confirmPayment($options)
    {
        $api = new Api\ConfirmPayment();

        if (isset($options['hash'])) {
            $api->setHash($options['hash']);
        }
        if (isset($options['emailAddress'])) {
            $api->setEmailAddress($options['emailAddress']);
        }
        if (isset($options['languageId'])) {
            $api->setLanguageId($options['languageId']);
        }

        $result = $api->doRequest();
        return new Result\ConfirmPayment($result);
    }
}
