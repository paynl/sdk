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

namespace Paynl\Result;

/**
 * Description of Transaction
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Transaction extends Result
{
    public function getId(){
        return $this->data['transactionId'];
    }
    public function isPaid(){
        return $this->data['paymentDetails']['stateName'] == 'PAID';
    }
    public function isPending(){
        return $this->data['paymentDetails']['stateName'] == 'PENDING';
    }
    public function isCanceled(){
        return $this->data['paymentDetails']['state'] < 0;
    }
    public function getPaidAmount(){
        return $this->data['paymentDetails']['paidAmount']/100;
    }
    public function getPaidCurrency(){
        return $this->data['paymentDetails']['paidCurrency'];
    }
    public function getAccountHolderName(){
        return $this->data['paymentDetails']['identifierName'];
    }
    public function getAccountNumber(){
        return $this->data['paymentDetails']['identifierPublic'];
    }
    public function getAccountHash(){
        return $this->data['paymentDetails']['identifierHash'];
    }
    public function getDescription(){
        return $this->data['paymentDetails']['description'];
    }
    public function getExtra1(){
        return $this->data['statsDetails']['extra1'];
    }
    public function getExtra2(){
        return $this->data['statsDetails']['extra2'];
    }
    public function getExtra3(){
        return $this->data['statsDetails']['extra3'];
    }

}