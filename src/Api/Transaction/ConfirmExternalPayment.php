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

namespace Paynl\Api\Transaction;

use Paynl\Error;

/**
 * Description of Confirm External Payment
 *
 * @author Marcel Schoolenberg <marcelschoolenberg@gmail.com>
 */
class ConfirmExternalPayment extends Transaction
{
    protected $apiTokenRequired = true;

    /**
     * @var string
     */
    private $transactionId;

	/**
     * @var string
     */
    private $customerId;

	/**
     * @var string
     */
    private $customerName;

	/**
     * @var string
     */
    private $paymentType;

    /**
     * Set the transactionId
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId){
        $this->transactionId = $transactionId;
    }

	/**
     * Set the customerId
     *
     * @param string $customerId
     */
    public function setCustomerId($customerId){
        $this->customerId = $customerId;
    }

	/**
     * Set the customerName
     *
     * @param string $customerName
     */
    public function setCustomerName($customerName){
        $this->customerName = $customerName;
    }

	/**
     * Set the paymentType
     *
     * @param string $paymentType
     */
    public function setPaymentType($paymentType){
        $this->paymentType = $paymentType;
    }

    /**
     * @inheritdoc
     * @throws Error\Required TransactionId is required
     */
    protected function getData() {
        if(empty($this->transactionId)){
            throw new Error\Required('TransactionId required');
        }

		if(empty($this->customerId)){
            throw new Error\Required('CustomerId required');
        }

        $this->data['transactionId'] = $this->transactionId;
		$this->data['customerId'] = $this->customerId;

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null) {
        return parent::doRequest('transaction/confirmExternalPayment');
    }
}