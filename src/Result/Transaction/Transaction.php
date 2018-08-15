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

namespace Paynl\Result\Transaction;

use Paynl\Error\Error;
use Paynl\Result\Result;

/**
 * Description of Transaction
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Transaction extends Result
{
    private $_cachedStatusResult = null;

    /**
     * @return bool Transaction is paid
     */
    public function isPaid()
    {
        return $this->data['paymentDetails']['stateName'] === 'PAID';
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->data['paymentDetails']['stateName'] === 'PENDING' || $this->data['paymentDetails']['stateName'] === 'VERIFY';
    }

    /**
     * Alias for isCanceled
     *
     * @return bool Transaction is Canceled
     */
    public function isCancelled()
    {
        return $this->isCanceled();
    }

    /**
     * @return bool Transaction is Canceled
     */
    public function isCanceled()
    {
        return $this->data['paymentDetails']['state'] < 0;
    }

    public function void()
    {
        if (!$this->isAuthorized()) {
            throw new Error('Cannod void transaction, status is not authorized');
        }

        return \Paynl\Transaction::void($this->getId());
    }

    public function isAuthorized()
    {
        return $this->data['paymentDetails']['state'] == 95;
    }

    /**
     * @return string The transaction id
     */
    public function getId()
    {
        return $this->data['transactionId'];
    }

    public function capture()
    {
        if (!$this->isAuthorized()) {
            throw new Error('Cannod capture transaction, status is not authorized');
        }

        return \Paynl\Transaction::capture($this->getId());
    }

    /**
     * @param bool|true $allowPartialRefunds
     *
     * @return bool
     */
    public function isRefunded($allowPartialRefunds = true)
    {
        if ($this->data['paymentDetails']['stateName'] === 'REFUND') {
            return true;
        }

        if ($allowPartialRefunds && $this->data['paymentDetails']['stateName'] === 'PARTIAL_REFUND') {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isPartiallyRefunded()
    {
        return $this->data['paymentDetails']['stateName'] === 'PARTIAL_REFUND';
    }

    /**
     * @return float The amount of the transaction (in EUR)
     */
    public function getAmount()
    {
        return $this->data['paymentDetails']['amount'] / 100;
    }

    /**
     * @return float The amount of the transaction (in the currency)
     */
    public function getCurrencyAmount()
    {
        return $this->data['paymentDetails']['currenyAmount'] / 100;
    }

    /**
     * @return float Paid amount in original currency
     */
    public function getPaidCurrencyAmount()
    {
        return $this->data['paymentDetails']['paidCurrenyAmount'] / 100;
    }

    /**
     * @return float Paid amount
     */
    public function getPaidAmount()
    {
        return $this->data['paymentDetails']['paidAmount'] / 100;
    }

    /**
     * @return string Currency in which the transaction is actually paid
     */
    public function getPaidCurrency()
    {
        return $this->data['paymentDetails']['paidCurrency'];
    }

    /**
     * @return string The name of the account holder
     */
    public function getAccountHolderName()
    {
        return $this->data['paymentDetails']['identifierName'];
    }

    /**
     * @return string The name of the payment method
     */
    public function getPaymentMethodName()
    {
        return $this->data['paymentDetails']['paymentProfileName'];
    }

    /**
     * @return string The account number, or masked creditcard number
     */
    public function getAccountNumber()
    {
        return $this->data['paymentDetails']['identifierPublic'];
    }

    /**
     * @return string The account number, or masked creditcard number
     */
    public function getAccountHash()
    {
        return $this->data['paymentDetails']['identifierHash'];
    }

    /**
     * @return string The transaction description, as defined while starting the transaction
     */
    public function getDescription()
    {
        return $this->data['paymentDetails']['description'];
    }

    /**
     * @return string The extra1 variable, as defined while starting the transaction
     */
    public function getExtra1()
    {
        return $this->data['statsDetails']['extra1'];
    }

    /**
     * @return string The extra2 variable, as defined while starting the transaction
     */
    public function getExtra2()
    {
        return $this->data['statsDetails']['extra2'];
    }

    /**
     * @return string The extra3 variable, as defined while starting the transaction
     */
    public function getExtra3()
    {
        return $this->data['statsDetails']['extra3'];
    }

    /**
     * @return float|int The refunded amount in euro
     * @throws Error
     * @throws \Paynl\Error\Api
     */
    public function getRefundedAmount()
    {
        return $this->getStatus()->getRefundedAmount();
    }

    /**
     * @return float|int The refunded amount in the used currency
     * @throws Error
     * @throws \Paynl\Error\Api
     */
    public function getRefundedCurrencyAmount()
    {
        return $this->getStatus()->getRefundedCurrencyAmount();
    }

    public function approve()
    {
        if (!$this->isBeingVerified()) {
            throw new Error("Cannot approve transaction because it does not have the status 'verify'");
        }

        $result = \Paynl\Transaction::approve($this->getId());
        $this->_reload(); //status is changed, so refresh the object

        return $result;
    }

    /**
     * @return Status
     * @throws Error
     * @throws \Paynl\Error\Api
     */
    public function getStatus()
    {
        if (is_null($this->_cachedStatusResult)) {
            $this->_cachedStatusResult = \Paynl\Transaction::status($this->getId());
        }
        return $this->_cachedStatusResult;
    }

    /**
     * @return bool
     */
    public function isBeingVerified()
    {
        return $this->data['paymentDetails']['stateName'] === 'VERIFY';
    }

    private function _reload()
    {
        $this->_cachedStatusResult = null;
        $result = \Paynl\Transaction::get($this->getId());
        $this->data = $result->getData();
    }

    public function decline()
    {
        if (!$this->isBeingVerified()) {
            throw new Error("Cannot decline transaction because it does not have the status 'verify'");
        }

        $result = \Paynl\Transaction::decline($this->getId());
        $this->_reload();//status is changed, so refresh the object

        return $result;
    }
}
