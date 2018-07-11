<?php
/*
 * Copyright (C) 2018 Andy Pieters <andy@pay.nl>
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

use Paynl\Result\Result;

/**
 * Result class for a Confirm External Payment
 *
 * @author Marcel Schoolenberg <marcelschoolenberg@gmail.com>
 */
class ConfirmExternalPayment extends Result
{
    /**
     * @return string The transactionId
     */
    public function getTransactionId()
    {
        return $this->data['transactionId'];
    }

    /**
     * @return string The CustomerId
     */
    public function getCustomerId()
    {
        return $this->data['customerId'];
    }

	/**
     * @return string The CustomerName
     */
    public function getCustomerName()
    {
        return $this->data['customerName'];
    }

	/**
     * @return string The PaymentType
     */
    public function getPaymentType()
    {
        return $this->data['paymentType'];
    }

	/**
     * @return boolean success
     */
    public function getSuccess()
    {
        return (boolean) $this->data['result'];
    }

	/**
     * @return string errorMessage
     */
    public function getErrorMessage()
    {
        return $this->data['errorMessage'];
    }

	/**
     * @return string errorId
     */
    public function getErrorId()
    {
        return $this->data['errorId'];
    }
}