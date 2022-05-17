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

$transactionId = '1234567890X1234a';

try {
    $result = \Paynl\Transaction::details($transactionId);

    echo $paymentDetails = print_r($result->getPaymentDetails()) . PHP_EOL;
    echo '$TransactionId = ' . $result->getTransactionId() . PHP_EOL;
    echo '$OrderId = ' . $result->getOrderId() . PHP_EOL;
    echo '$OrderNumber = ' . $result->getOrderNumber() . PHP_EOL;
    echo '$PaymentProfileId = ' . $result->getPaymentProfileId() . PHP_EOL;
    echo '$PaymentProfileName = ' . $result->getPaymentProfileName() . PHP_EOL;
    echo '$State = ' . $result->getState() . PHP_EOL;
    echo '$StateName = ' . $result->getStateName() . PHP_EOL;
    echo '$Language = ' . $result->getLanguage() . PHP_EOL;
    echo '$StartDate = ' . $result->getStartDate() . PHP_EOL;
    echo '$CompleteDate = ' . $result->getCompleteDate() . PHP_EOL;
    echo '$StartIpAddress = ' . $result->getStartIpAddress() . PHP_EOL;
    echo '$CompletedIpAddress = ' . $result->getCompletedIpAddress() . PHP_EOL;
    echo '$Amount = ' . print_r($result->getAmount()) . PHP_EOL;
    echo '$AmountValue = ' . $result->getAmountValue() . PHP_EOL;
    echo '$AmountCurrency = ' . $result->getAmountCurrency() . PHP_EOL;
    echo '$AmountOriginal = ' . print_r($result->getAmountOriginal()) . PHP_EOL;
    echo '$AmountOriginalValue = ' . $result->getAmountOriginalValue() . PHP_EOL;
    echo '$AmountOriginalCurrency = ' . $result->getAmountOriginalCurrency() . PHP_EOL;
    echo '$AmountPaidOriginal = ' . print_r($result->getAmountPaidOriginal()) . PHP_EOL;
    echo '$AmountPaidOriginalValue = ' . $result->getAmountPaidOriginalValue() . PHP_EOL;
    echo '$AmountPaidOriginalCurrency = ' . $result->getAmountPaidOriginalCurrency() . PHP_EOL;
    echo '$AmountPaid = ' . print_r($result->getAmountPaid()) . PHP_EOL;
    echo '$AmountPaidValue = ' . $result->getAmountPaidValue() . PHP_EOL;
    echo '$AmountPaidCurrency = ' . $result->getAmountPaidCurrency() . PHP_EOL;
    echo '$AmountRefundOriginal = ' . print_r($result->getAmountRefundOriginal()) . PHP_EOL;
    echo '$AmountRefundOriginalValue = ' . $result->getAmountRefundOriginalValue() . PHP_EOL;
    echo '$AmountRefundOriginalCurrency = ' . $result->getAmountRefundOriginalCurrency() . PHP_EOL;
    echo '$AmountRefund = ' . print_r($result->getAmountRefund()) . PHP_EOL;
    echo '$AmountRefundValue = ' . $result->getAmountRefundValue() . PHP_EOL;
    echo '$AmountRefundCurrency = ' . $result->getAmountRefundCurrency() . PHP_EOL;
    echo '$Request = ' . print_r($result->getRequest()) . PHP_EOL;
    echo '$Data = ' . print_r($result->getData()) . PHP_EOL;

    $arrTransactionDetails = $result->getTransactionDetails();
    $transactionDetails = isset($arrTransactionDetails[0]) ? $arrTransactionDetails[0] : false;

    if ($transactionDetails !== false) {
        echo '$TransactionDetails = ' . print_r($result->getTransactionDetails()) . PHP_EOL;
        echo '$TransactionId = ' . $transactionDetails->getTransactionId() . PHP_EOL;
        echo '$OrderId = ' . $transactionDetails->getOrderId() . PHP_EOL;
        echo '$ReportingId = ' . $transactionDetails->getReportingId() . PHP_EOL;
        echo '$State = ' . $transactionDetails->getState() . PHP_EOL;
        echo '$StateName = ' . $transactionDetails->getStateName() . PHP_EOL;
        echo '$StartDate = ' . $transactionDetails->getStartDate() . PHP_EOL;
        echo '$CompleteDate = ' . $transactionDetails->getCompleteDate() . PHP_EOL;
        echo '$PaymentProfileId = ' . $transactionDetails->getPaymentProfileId() . PHP_EOL;
        echo '$PaymentProfileName = ' . $transactionDetails->getPaymentProfileName() . PHP_EOL;
        echo '$IdentifierName = ' . $transactionDetails->getIdentifierName() . PHP_EOL;
        echo '$IdentifierType = ' . $transactionDetails->getIdentifierType() . PHP_EOL;
        echo '$IdentifierPublic = ' . $transactionDetails->getIdentifierPublic() . PHP_EOL;
        echo '$IdentifierHash = ' . $transactionDetails->getIdentifierHash() . PHP_EOL;
        echo '$Amount = ' . print_r($transactionDetails->getAmount()) . PHP_EOL;
        echo '$AmountValue = ' . $transactionDetails->getAmountValue() . PHP_EOL;
        echo '$AmountCurrency = ' . $transactionDetails->getAmountCurrency() . PHP_EOL;
    }

} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}