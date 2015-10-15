<?php
/*
 * Copyright (C) 2015 Pay.nl
 */

namespace Paynl\Result;

/**
 * Description of Transaction
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Transaction extends Result
{
    public function isPaid(){
        return $this->data['paymentDetails']['stateName'] == 'PAID';
    }
}