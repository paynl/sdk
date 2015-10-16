<?php
/*
 * Copyright (C) 2015 Andy Pieters <andy@andypieters.nl>
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

namespace Paynl;

use Paynl\Result;
use Paynl\Api\Transaction as Api;
/**
 * Description of Transaction
 *
 * @author Andy Pieters <andy@andypieters.nl>
 */
class Transaction
{
    public static function start($options = array()){
        $api = new Api\Start();

        if(isset($options['amount'])){
            $api->setAmount(round($options['amount']*100));
        }
        if(isset($options['returnUrl'])){
            $api->setFinishUrl($options['returnUrl']);
        }
        if(isset($options['paymentMethod']) && !empty($options['paymentMethod'])){
            $api->setPaymentOptionId($options['paymentMethod']);
        }
        if(isset($options['bank']) && !empty($options['bank'])){
            $api->setPaymentOptionSubId($options['bank']);
        }

        $result = $api->doRequest();

        return new Result\Start($result);
    }
    
    public static function get($transactionId){
        $api = new Api\Info();
        $api->setTransactionId($transactionId);
        $result = $api->doRequest();
        return new Result\Transaction($result);
    }

}