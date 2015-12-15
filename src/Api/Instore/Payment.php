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

namespace Paynl\Api\Instore;

use Paynl\Error;
/**
 * Description of Status
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Payment extends Instore
{   
    private $transactionId;

    private $terminalId;

    protected function getData() {
        if(empty($this->transactionId)){
            throw new Error\Required('transactionId is niet geset');
        }
        $this->data['transactionId'] = $this->transactionId;

        if(!empty($this->terminalId)){
            $this->data['terminalId'] = $this->terminalId;
        }

        return parent::getData();
    }
    public function setTransactionId($transactionId){
        $this->transactionId = $transactionId;
    }

    public function setTerminalId($terminalId){
        $this->terminalId = $terminalId;
    }

    public function doRequest($endpoint = null, $version = null) {
        return parent::doRequest('instore/payment');
    }
}