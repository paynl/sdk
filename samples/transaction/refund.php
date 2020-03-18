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

$transactionId = $_GET['transactionId'];
try {
    /*$example = \Paynl\Transaction::refund(
        TRANSACTION ID(string) - Required, 
        AMOUNT(float) - Empty = full refund, 
        DESCRIPTION(string), 
        DATE REFUND WILL BE PROCESSED(DateTime), 
        VAT PERCENTAGE(float), 
        CURRENCY(string) - Default EURO
    );*/
    
    $result = \Paynl\Transaction::refund($transactionId, 0.01, 'description', new DateTime(18-03-2020), 0, 'USD');
    
    /*
    * Getters
    * description = $result->getDescription();
    * orderId = $result->getOrderId();
    * amount = $result->getAmount();
    * refundAmount = $result->getRefundAmount();
    * bankaccountNumber = $result->getBankaccountNumber();
    * refundId = $result->getRefundId();
    */

} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}
