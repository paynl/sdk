[![Latest Stable Version](https://poser.pugx.org/paynl/sdk/v/stable)](https://packagist.org/packages/paynl/sdk)
[![Total Downloads](https://poser.pugx.org/paynl/sdk/downloads)](https://packagist.org/packages/paynl/sdk)
[![Latest Unstable Version](https://poser.pugx.org/paynl/sdk/v/unstable)](https://packagist.org/packages/paynl/sdk)
[![Build Status](https://travis-ci.org/paynl/sdk.svg?branch=master)](https://travis-ci.org/paynl/sdk)
[![Coverage Status](https://coveralls.io/repos/github/paynl/sdk/badge.svg?branch=master)](https://coveralls.io/github/paynl/sdk?branch=master)
# Pay.nl PHP SDK

---

- [Installation](#installation)
- [Installation without composer](#installation-without-composer)
- [Requirements](#requirements)
- [Quick start and examples](#quick-start-and-examples)

---

### Installation

This SDK uses composer.

Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.

For more information on how to use/install composer, please visit: [https://github.com/composer/composer](https://github.com/composer/composer)

To install the Pay.nl PHP sdk into your project, simply

	$ composer require paynl/sdk
	
### Installation without composer

If you don't have experience with composer, it is possible to use the SDK without using composer.

You can download the zip on the projects [releases](https://github.com/paynl/sdk/releases) page.

1. Download the package zip (SDKvx.x.x.zip).
2. Unzip the contents of the zip, and upload the vendor directory to your server.
3. In your project, require the file vendor/autoload.php
4. You can now use the SDK in your project

### Requirements

The Pay.nl PHP SDK works on php versions 5.6 or higher, and requires the php curl extension.

### Quick start and examples

Set the configuration
```php
require __DIR__ . '/vendor/autoload.php';

# Replace tokenCode apitoken and serviceId with your own.
\Paynl\Config::setTokenCode('AT-####-####');
\Paynl\Config::setApiToken('****************************************');
\Paynl\Config::setServiceId('SL-####-####');
```

Get available payment methods
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setTokenCode('AT-####-####');
\Paynl\Config::setApiToken('****************************************');
\Paynl\Config::setServiceId('SL-####-####');

$paymentMethods = \Paynl\Paymentmethods::getList();
var_dump($paymentMethods);
```

Start a transaction
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setTokenCode('AT-####-####');
\Paynl\Config::setApiToken('****************************************');
\Paynl\Config::setServiceId('SL-####-####');

$result = \Paynl\Transaction::start(array(
    # Required
        'amount' => 10.00,
        'returnUrl' => Paynl\Helper::getBaseUrl().'/return.php',

    # Optional
    	'currency' => 'EUR',
        'exchangeUrl' => Paynl\Helper::getBaseUrl().'/exchange.php',
        'paymentMethod' => 10,
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
                'price' => 5.00,
                'tax' => 0.87,
                'qty' => 1,
            ),
            array(
                'id' => 2,
                'name' => 'ander product',
                'price' => 5.00,
                'tax' => 0.87,
                'qty' => 1,
            )
        ),
        'language' => 'EN',
        'ipaddress' => '127.0.0.1',
        'invoiceDate' => new DateTime('2016-02-16'),
        'deliveryDate' => new DateTime('2016-06-06'), // in case of tickets for an event, use the event date here
        'enduser' => array(
            'initials' => 'T',
            'lastName' => 'Test',
            'gender' => 'M',
            'birthDate' => new DateTime('1990-01-10'),
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

# Save this transactionid and link it to your order
$transactionId = $result->getTransactionId();

# Redirect the customer to this url to complete the payment
$redirect = $result->getRedirectUrl();
```

On the return page, redirect the user to the thank you page or back to checkout
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setTokenCode('AT-####-####');
\Paynl\Config::setApiToken('****************************************');

$transactionId = $_REQUEST['orderId'];

$transaction = \Paynl\Transaction::status($transactionId);

# Manual transfer transactions are always pending when the user is returned
if( $transaction->isPaid() || $transaction->isPending()) {
   # Redirect to thank you page
} elseif($transaction->isCanceled()) {
   # Redirect back to checkout
}
```

On the exchange script, process the order
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setTokenCode('AT-####-####');
\Paynl\Config::setApiToken('****************************************');

$transactionId = $_REQUEST['order_id'];

$transaction = \Paynl\Transaction::status($transactionId);

if($transaction->isPaid() || $transaction->isAuthorized()) {
    # Process the payment
} elseif($transaction->isCanceled()) {
    # Payment canceled, restock items
}

# Always respond with TRUE|
echo "TRUE| ";

# Optionally you can send a message after TRUE|, you can view these messages in the logs.
# https://admin.pay.nl/logs/payment_state
echo ($transaction->isPaid() || $transaction->isAuthorized())?'Paid':'Not paid';


```

### Testing
Please run ```vendor/bin/phpunit --bootstrap vendor/autoload.php  tests/``` to test the application
