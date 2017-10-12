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

require_once '../../vendor/autoload.php';
require_once '../config.php';

try {
    $result = \Paynl\Transaction::start([
    	// Required
        'amount' => 12.5,
        'returnUrl' => dirname(Paynl\Helper::getBaseUrl()) . '/return.php',
        'ipaddress' => \Paynl\Helper::getIp(),

	    // Optional
        'exchangeUrl' => dirname(Paynl\Helper::getBaseUrl()) . '/exchange.php',
        'paymentMethod' => 10,// iDEAL use \Paynl\PaymentMethods::getList() to get all available paymentmethods
        'description' => '123456', // the transaction description, usually the orderId
    ]);

	// Save this transactionId and link it to your order
    $transactionId = $result->getTransactionId();

    // redirect user to payment page
    header('location: '.$result->getRedirectUrl());

} catch (\Paynl\Error\Error $e) {
	// An error has occurred
    echo "Fout: " . $e->getMessage();
}
