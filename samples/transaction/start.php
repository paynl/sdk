<?php

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
        'transferData' => array(
            'transferData1' => 'transferData1',
            'transferData2' => 'transferData2'
        ),
        'ipaddress' => '10.0.0.1',
        'invoiceDate' => new \DateTime('now'),
        'deliveryDate' => new \DateTime('2016-06-06'), // in case of tickets for an event, use the event date here
        'products' => array(
            array(
                'id' => 1,
                'name' => 'my product',
                'price' => 5,
                'vatPercentage' => 21,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_ARTICLE
            ),
            array(
                'id' => 2,
                'name' => 'other product 9 %',
                'price' => 5,
                'vatPercentage' => 9,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_ARTICLE
            ),
            array(
                'id' => 'shipping',
                'name' => 'Next day delivery',
                'price' => 5,
                'vatPercentage' => 21,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_SHIPPING
            ),
            array(
                'id' => 'fee',
                'name' => 'Giftwrapping',
                'price' => 1,
                'vatPercentage' => 21,
                'qty' => 1,
                'type' => \Paynl\Transaction::PRODUCT_TYPE_HANDLING
            ),
            array(
                'id' => '5543',
                'name' => 'Coupon 3,50 discount',
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
            'emailAddress' => 'testbetaling@pay.nl',
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
