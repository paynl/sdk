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
 * Description of Approve
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class AddRecurring extends Transaction
{
    protected $apiTokenRequired = true;

    /**
     * @var string
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
     * @var string additional data extra1
     */
    private $extra1;
    /**
     * @var string additional data extra2
     */
    private $extra2;
    /**
     * @var string additional data extra3
     */
    private $extra3;

    /**
     * @param mixed $amount
     * @throws Error\Error
     */
    public function setAmount($amount)
    {
        if (!is_numeric($amount)) {
            throw new Error\Error('Amount must be numeric');
        }
        $this->amount = $amount;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $extra1
     */
    public function setExtra1($extra1)
    {
        $this->extra1 = $extra1;
    }

    /**
     * @param mixed $extra2
     */
    public function setExtra2($extra2)
    {
        $this->extra2 = $extra2;
    }

    /**
     * @param mixed $extra3
     */
    public function setExtra3($extra3)
    {
        $this->extra3 = $extra3;
    }

    /**
     * Set the transactionId
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @inheritdoc
     * @throws Error\Required TransactionId is niet geset
     */
    protected function getData()
    {
        if (empty($this->transactionId)) {
            throw new Error\Required('TransactionId is required');
        }

        $this->data['transactionId'] = $this->transactionId;

        if (isset($this->amount)) {
            $this->data['amount'] = $this->amount;
        }
        if (isset($this->description)) {
            $this->data['description'] = $this->description;
        }
        if (isset($this->extra1)) {
            $this->data['extra1'] = $this->extra1;
        }
        if (isset($this->extra2)) {
            $this->data['extra2'] = $this->extra2;
        }
        if (isset($this->extra3)) {
            $this->data['extra3'] = $this->extra3;
        }

        return parent::getData();
    }

    /**
     * @inheritdoc
     */
    public function doRequest($endpoint = null, $version = null)
    {
        return parent::doRequest('transaction/addRecurring');
    }
}
