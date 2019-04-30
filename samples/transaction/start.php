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
    $result = \Paynl\Transaction::start(array(
        // required
        'amount' => 12.5,
        'returnUrl' => dirname(\Paynl\Helper::getBaseUrl()) . '/return.php',

        // optional
        'exchangeUrl' => dirname(\Paynl\Helper::getBaseUrl()) . '/exchange.php',
        'paymentMethod' => 10,
        'currency' => 'EUR',
        'expireDate' => new \DateTime('2016-04-01'),
//        'bank' => 1,
        'orderNumber' => 'ABCDEFG12346', // max 16 alphanumeric characters
        'description' => '123456',
        'testmode' => 0,
        'extra1' => 'ext1',
        'extra2' => 'ext2',
        'extra3' => 'ext3',
        'ipaddress' => '10.0.0.1',
        'invoiceDate' => new \DateTime('now'),
        'deliveryDate' => new \DateTime('2016-06-06'), // in case of tickets for an event, use the event date here
        'products' => array(
            array(
                'id' => 1,
                'name' => 'een product',
                'price' => 5,
                'vatPercentage' => 21,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_DISCOUNT
            ),
            array(
                'id' => 2,
                'name' => 'ander product 15 %',
                'price' => 5,
                'vatPercentage' => 15,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_ARTICLE
            ),
            array(
                'id' => 'shipping',
                'name' => 'verzendkosten',
                'price' => 5,
                'vatPercentage' => 21,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_SHIPPING
            ),
            array(
                'id' => 'fee',
                'name' => 'Handling fee',
                'price' => 1,
                'vatPercentage' => 21,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_HANDLING
            ),
            array(
                'id' => '5543',
                'name' => 'Coupon 3,50 korting',
                'price' => -3.5,
                'vatPercentage' => 21,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_DISCOUNT
            ),
        ),
        'language' => 'EN',
        'enduser' => array(
            'initials' => 'T',
            'lastName' => 'Test',
            'gender' => 'M',
            'birthDate' => new \DateTime('1999-02-15'),
            'phoneNumber' => '0612345678',
            'emailAddress' => 'test@test.nl',
            'customerReference' => '456789',//your customer id
            'customerTrust' => 0, // -10 - 10 how much do you trust this customer? -10 untrustable 10 trusted
        ),
        'address' => array(
            'streetName' => 'Test',
            'houseNumber' => '10',
            'houseNumberExtension' => 'A',
            'zipCode' => '1234AB',
            'city' => 'Test',
            'country' => 'NL',
        ),
        'company' => array(
            'name' => 'CompanyName',
            'cocNumber' => '12345678',
            'vatNumber' => 'NL0123456789',
            'countryCode' => 'NL'
        ),
        'invoiceAddress' => array(
            'initials' => 'IT',
            'lastName' => 'ITEST',
            'streetName' => 'Istreet',
            'houseNumber' => '70',
            'houseNumberExtension' => 'A',
            'zipCode' => '5678CD',
            'city' => 'ITest',
            'country' => 'NL',
        ),
        'object' => 'Object', // 64 characters max

        // Only use this if you are told to
//        'transferType' => 'merchant',
//        'transferValue' => 'M-0123-4567', // the merchantCode
//
//        'transferType' => 'transaction',
//        'transferValue' => '12345678X260bc5', // The transactionId
    ));

    // Save this transactionid and link it to your order
    $transactionId = $result->getTransactionId();

    echo '<a href="' . $result->getRedirectUrl() . '">' . $result->getRedirectUrl() . '</a>';
    echo "<br />" . $transactionId;
} catch (\Paynl\Error\Error $e) {
    echo "Fout: " . $e->getMessage();
}
