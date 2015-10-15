<?php
/*
 * Copyright (C) 2015 Pay.nl
 */

namespace Paynl\Api\Transaction;


use Paynl\Api\Api;
use Paynl\Error;
/**
 * Description of Info
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Info extends Api
{
    private $transactionId;

    protected function getData() {
        if(empty($this->transactionId)){
            throw new Error\Required('TransactionId is niet geset');
        }
        $this->data['transactionId'] = $this->transactionId;
        return parent::getData();
    }
    public function setTransactionId($transactionId){
        $this->transactionId = $transactionId;
    }
    public function doRequest($endpoint = null) {
        return parent::doRequest('transaction/info');
    }
}