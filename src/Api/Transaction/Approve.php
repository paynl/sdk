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
class Approve extends Transaction
{
    protected $apiTokenRequired = true;
    protected $serviceIdRequired = false;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * Get data to send to the api
     *
     * @return array
     * @throws Error\Required
     */
    protected function getData() {
        if(empty($this->transactionId)){
            throw new Error\Required('TransactionId is niet geset');
        }
        $this->data['orderId'] = $this->transactionId;
        return parent::getData();
    }

    /**
     * Set the transactionId
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId){
        $this->transactionId = $transactionId;
    }

    /**
     * Do the request
     *
     * @param null $endpoint
     * @param null $version
     * @return array the result
     */
    public function doRequest($endpoint = null, $version = null) {
        return parent::doRequest('transaction/approve');
    }
}