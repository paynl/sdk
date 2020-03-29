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

$transactionId = 'EX-1234-5678-9012';

try {
    /*$example = \Paynl\Transaction::details(
        TransactionId(string) - Required,
        entranceCode(string) - Optional
    );*/
    
    $result = \Paynl\Transaction::details($transactionId);  
  
    /**
    * GETTERS
    *
    * paymentDetails = getPaymentDetails() @var array
    * TransactionId = getTransactionId() @var string
    * OrderId = getOrderId() @var string
    * OrderNumber = getOrderNumber() @var string
    * PaymentProfileId = getPaymentProfileId() @var string
    * PaymentProfileName = getPaymentProfileName() @var string
    * State = getState() @var string
    * StateName = getStateName() @var string
    * Language = getLanguage() @var string
    * StartDate = getStartDate() @var string
    * CompleteDate = getCompleteDate() @var string
    * StartIpAddress = getStartIpAddress() @var string
    * CompletedIpAddress = getCompletedIpAddress() @var string
    * Amount = getAmount() @var array
    * AmountValue = getAmountValue() @var string
    * AmountCurrency = getAmountCurrency() @var string
    * AmountOriginal = getAmountOriginal() @var array
    * AmountOriginalValue = getAmountOriginalValue() @var string
    * AmountOriginalCurrency = getAmountOriginalCurrency() @var string
    * AmountPaidOriginal = getAmountPaidOriginal() @var array
    * AmountPaidOriginalValue = getAmountPaidOriginalValue() @var string
    * AmountPaidOriginalCurrency = getAmountPaidOriginalCurrency() @var string
    * AmountPaid = getAmountPaid() @var array
    * AmountPaidValue = getAmountPaidValue() @var string
    * AmountPaidCurrency = getAmountPaidCurrency() @var string
    * AmountRefundOriginal = getAmountRefundOriginal() @var array
    * AmountRefundOriginalValue = getAmountRefundOriginalValue() @var string
    * AmountRefundOriginalCurrency = getAmountRefundOriginalCurrency() @var string
    * AmountRefund = getAmountRefund() @var array
    * AmountRefundValue = getAmountRefundValue() @var string
    * AmountRefundCurrency = getAmountRefundCurrency()     @var string
    * Request = getRequest() @var array
    * Data = getData() @var array

    * TransactionDetails = getTransactionDetails() @var array

    * TransactionId = getTransactionDetails()[0]->getTransactionId() @var string
    * OrderId = getTransactionDetails()[0]->getOrderId() @var string
    * ReportingId = getTransactionDetails()[0]->getReportingId() @var string
    * State = getTransactionDetails()[0]->getState() @var string
    * StateName = getTransactionDetails()[0]->getStateName() @var string
    * StartDate = getTransactionDetails()[0]->getStartDate() @var string
    * CompleteDate = getTransactionDetails()[0]->getCompleteDate() @var string
    * PaymentProfileId = getTransactionDetails()[0]->getPaymentProfileId() @var string
    * PaymentProfileName = getTransactionDetails()[0]->getPaymentProfileName() @var string
    * IdentifierName = getTransactionDetails()[0]->getIdentifierName() @var string
    * IdentifierType = getTransactionDetails()[0]->getIdentifierType() @var string
    * IdentifierPublic = getTransactionDetails()[0]->getIdentifierPublic() @var string
    * IdentifierHash = getTransactionDetails()[0]->getIdentifierHash() @var string
    * Amount = getTransactionDetails()[0]->getAmount() @var array
    * AmountValue = getTransactionDetails()[0]->getAmountValue() @var string
    * AmountCurrency = getTransactionDetails()[0]->getAmountCurrency() @var string
    * Request = getTransactionDetails()[0]->getRequest() @var array
    * Data = getTransactionDetails()[0]->getData() @var array
    
    */

} catch (\Paynl\Error\Error $e) {
    echo $e->getMessage();
}

