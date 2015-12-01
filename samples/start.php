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

require_once '../vendor/autoload.php';

\Paynl\Config::setApiToken('e41f83b246b706291ea9ad798ccfd9f0fee5e0ab');
\Paynl\Config::setServiceId('SL-3490-4320');

$result = \Paynl\Transaction::start(array(
        // required
        'amount' => 10,
        'returnUrl' => Paynl\Helper::getBaseUrl().'/return.php',
        // optional
        'exchangeUrl' => Paynl\Helper::getBaseUrl().'/exchange.php',
        'paymentMethod' => 10,
        'currency' => 'USD',
        'bank' => 1,
        'description' => 'demo betaling',
        'testmode' => 1,
        'extra1' => 'ext1',
        'extra2' => 'ext2',
        'extra3' => 'ext3',
        'products' => array(
            array(
                'id' => 1,
                'name' => 'een product',
                'price' => 5,
                'tax' => 0.87,
                'qty' => 1,
            ),
            array(
                'id' => 2,
                'name' => 'ander product',
                'price' => 5,
                'tax' => 0.87,
                'qty' => 1,
            )
        ),
        'language' => 'EN',
        'enduser' => array(
            'initials' => 'T',
            'lastName' => 'Test',
            'gender' => 'M',
            'dob' => '14-05-1999',
            'phoneNumber' => '0612345678',
            'emailAddress' => 'test@test.nl',
        ),
        'address' => array(
            'streetName' => 'Test',
            'houseNumber' => '10',
            'zipCode' => '1234AB',
            'city' => 'Test',
            'country' => 'NL',
        ),
        'invoiceAddress' => array(
            'initials' => 'IT',
            'lastName' => 'ITEST',
            'streetName' => 'Istreet',
            'houseNumber' => '70',
            'zipCode' => '5678CD',
            'city' => 'ITest',
            'country' => 'NL',
        ),
    ));

// Save this transactionid and link it to your order
$transactionId = $result->getTransactionId();

echo '<a href="'.$result->getRedirectUrl().'">'.$result->getRedirectUrl().'</a>';
