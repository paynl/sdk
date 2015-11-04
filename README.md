# Pay.nl PHP SDK

---

- [Installation](#installation)
- [Requirements](#requirements)
- [Quick start and examples](#quick-start-and-examples)

---

### Installation

This SDK uses composer.

Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.

For more information on how to use/install composer, please visit: [https://github.com/composer/composer](https://github.com/composer/composer)

To install the Pay.nl PHP sdk into your project, simply

	$ composer require paynl/sdk

### Requirements

The Pay.nl PHP SDK works on php versions 5.3, 5.4, 5.5 and 5.6.
Also the php curl extension needs to be installed.

### Quick start and examples

Set the configuration
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setApiToken('e41f83b246b706291ea9ad798ccfd9f0fee5e0ab');
\Paynl\Config::setServiceId('SL-3490-4320');
```

Get available payment methods
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setApiToken('e41f83b246b706291ea9ad798ccfd9f0fee5e0ab');
\Paynl\Config::setServiceId('SL-3490-4320');

$paymentMethods = \Paynl\Paymentmethods::getList();
var_dump($paymentMethods);
```

Start a transaction
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setApiToken('e41f83b246b706291ea9ad798ccfd9f0fee5e0ab');
\Paynl\Config::setServiceId('SL-3490-4320');

$result = \Paynl\Transaction::start(array(
    // required
        'amount' => 10,
        'returnUrl' => Paynl\Helper::getBaseUrl().'/return.php',

    // optional
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

// Redirect the customer to this url to complete the payment
$redirect = $result->getRedirectUrl();
```

On the return page, redirect the user to the thank you page or back to checkout
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setApiToken('e41f83b246b706291ea9ad798ccfd9f0fee5e0ab');

$transaction = \Paynl\Transaction::getForReturn();

//manual transfer transactions are always pending when the user is returned
if( $transaction->isPaid() || $transaction->isPending() 
    ){
    // redirect to thank you page
    
} elseif($transaction->isCanceled()) {
    // redirect back to checkout
   
}
```

On the exchange script, process the order
```php
require __DIR__ . '/vendor/autoload.php';

\Paynl\Config::setApiToken('e41f83b246b706291ea9ad798ccfd9f0fee5e0ab');

$transaction = \Paynl\Transaction::getForExchange();

if($transaction->isPaid()){
    // process the payment
} elseif($transaction->isCanceled()){
    // payment canceled, restock items
}

// always start your response with TRUE|
echo "TRUE| ";

// Optionally you can send a message after TRUE|, you can view this messages in the logs.
// https://admin.pay.nl/logs/payment_state
echo $transaction->isPaid()?'Paid':'Not paid';


```
