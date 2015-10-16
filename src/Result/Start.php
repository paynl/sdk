<?php
/*
 * Copyright (C) 2015 Pay.nl
 */

namespace Paynl\Result;

/**
 * Description of Start
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Start extends Result
{
    public function getTransactionId(){
        return $this->data['transaction']['transactionId'];
    }
    public function getRedirectUrl(){
        return $this->data['transaction']['paymentURL'];
    }
    public function getPaymentReference(){
        return $this->data['transaction']['paymentReference'];
    }
}