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

namespace Paynl\Api\Transaction;

use Paynl\Error;

/**
 * Api class to refund a transaction
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Refund extends Transaction
{
    protected $apiTokenRequired = true;

    /**
     * @var string the transactionId
     */
    private $transactionId;

    /**
     * @var int the amount in cents
     */
    private $amount;
    /**
     * @var string the description for this refund
     */
    private $description;
    /**
     * @var \DateTime the date the refund should take place
     */
    private $processDate;

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = (int)$amount;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param \DateTime $processDate
     */
    public function setProcessDate(\DateTime $processDate)
    {
        $this->processDate = $processDate;
    }

    /**
     * @inheritdoc
     * @throws Error\Required TransactionId is required
     */
    protected function getData()
    {
        if (empty($this->transactionId)) {
            throw new Error\Required('TransactionId is required');
        }

        $this->data['transactionId'] = $this->transactionId;

        if (!empty($this->amount)) {
            $this->data['amount'] = $this->amount;
        }
        if (!empty($this->description)) {
            $this->data['description'] = $this->description;
        }
        if ($this->processDate instanceof \DateTime) {
            $this->data['processDate'] = $this->processDate->format('d-m-Y');
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/refund');
    }
}
