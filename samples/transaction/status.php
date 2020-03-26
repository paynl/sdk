<?php
/*
 * Copyright (C) 2020 PAY. <support@pay.nl>
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

require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    /*$example = \Paynl\Transaction::status(
        TRANSACTION ID(string) - Required
    );*/
    
    $result = \Paynl\Transaction::status($transactionId);
    
    /*
    * Getters
    * transactionId = $result->getTransactionId();
    * orderId = $result->getOrderId();
    * paymentProfileId = $result->getPaymentProfileId();
    * state = $result->getState();
    * stateName = $result->getStateName();
    * currency = $result->getCurrency();
    * amount = $result->getAmount();
    * currencyAmount = $result->getCurrencyAmount();
    * paidAmount = $result->getPaidAmount();
    * paidCurrencyAmount = $result->getPaidCurrencyAmount();
    * refundedAmount = $result->getRefundedAmount();
    * refundedCurrencyAmount = $result->getRefundedCurrencyAmount();
    */

} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}
