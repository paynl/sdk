<?php

class TransactionTest extends PHPUnit_Framework_TestCase
{
    private $testApiResult;

    private function setDummyData($name)
    {
        $this->testApiResult = file_get_contents(__DIR__ . '/dummyData/Transaction/' . $name . '.json');
        $curl = new \Paynl\Curl\Dummy();
        $curl->setResult($this->testApiResult);
        \Paynl\Config::setCurl($curl);
    }

    /**
     * Start a transaction with all options
     *
     * @return \Paynl\Result\Transaction\Start
     */
    private function startTransactionFull()
    {
        $this->setDummyData('startOk');
        $result = \Paynl\Transaction::start(array(
            // required
            'amount' => 10,
            'returnUrl' => '/return.php',

            // optional
            'exchangeUrl' => '/exchange.php',
            'paymentMethod' => 10,
            'currency' => 'EUR',
            'expireDate' => 'tomorrow',
            'bank' => 1,
            'description' => '123456',
            'testmode' => 1,
            'extra1' => 'ext1',
            'extra2' => 'ext2',
            'extra3' => 'ext3',
            'ipaddress' => '123.123.123.123',
            'invoiceDate' => 'now',
            'transferType' => 'transaction',
            'transferValue' => '123441x12341',
            'deliveryDate' => 'tomorrow', // in case of tickets for an event, use the event date here
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
                'birthDate' => '14-05-1999',
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
                'gender' => 'F'
            ),
        ));
        return $result;
    }

    public function testStartNoToken()
    {
        $this->setExpectedException('\Paynl\Error\Required\ApiToken');

        \Paynl\Config::setApiToken('');
        \Paynl\Config::setServiceId('SL-1234-5678');

        $this->startTransactionFull();
    }

    public function testStartNoServiceId()
    {
        $this->setExpectedException('\Paynl\Error\Required\ServiceId');

        \Paynl\Config::setApiToken('123456789012345678901234567890');
        \Paynl\Config::setServiceId('');

        $this->startTransactionFull();
    }

    public function testStartNoAmount()
    {
        $this->setExpectedException('\Paynl\Error\Required');
        $this->setDummyData('startOk');
        \Paynl\Config::setApiToken('123456789012345678901234567890');
        \Paynl\Config::setServiceId('SL-1234-5678');

        \Paynl\Transaction::start(array(
            'returnUrl' => '/return.php',
            'ipaddress' => '127.0.0.1',
        ));
    }

    public function testStartNoReturn()
    {
        $this->setExpectedException('\Paynl\Error\Required');
        $this->setDummyData('startOk');
        \Paynl\Config::setApiToken('123456789012345678901234567890');
        \Paynl\Config::setServiceId('SL-1234-5678');

        \Paynl\Transaction::start(array(
            'amount' => 10,
            'ipaddress' => '127.0.0.1',
        ));
    }

    public function testStartMinumumOk()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');
        \Paynl\Config::setServiceId('SL-1234-5678');

        $this->setDummyData('startOk');
        $result = \Paynl\Transaction::start(array(
            'amount' => 10,
            'returnUrl' => '/return.php',
            'ipaddress' => '127.0.0.1',
        ));

        $this->validateStartResult($result);
    }

    private function validateStartResult($result)
    {
        $this->assertInstanceOf('\Paynl\Result\Transaction\Start', $result);

        /**
         * @var $result \Paynl\Result\Transaction\Start
         */

        $this->assertNotEmpty($result->getTransactionId(), 'Could not get the transactionId');
        $this->assertNotEmpty($result->getPaymentReference(), 'Could not get the PaymentReference');
        $this->assertNotEmpty($result->getRedirectUrl(), 'Could not get the redirectUrl');
    }

    public function testStartFullOk()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');
        \Paynl\Config::setServiceId('SL-1234-5678');

        $result = $this->startTransactionFull();

        $this->validateStartResult($result);
    }

    public function testGetTransactionPaid()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/transactionPaid');

        $transaction = Paynl\Transaction::get('645958819Xdd3ea1');

        $this->assertInstanceOf('\Paynl\Result\Transaction\Transaction', $transaction);
    }

    public function testGetForReturn()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/transactionPaid');

        $_GET['orderId'] = "645958819Xdd3ea1";

        $transaction = Paynl\Transaction::getForReturn();
        $this->assertInstanceOf('\Paynl\Result\Transaction\Transaction', $transaction);
    }

    public function testGetForExchange()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/transactionPaid');

        $_GET['order_id'] = "645958819Xdd3ea1";

        $transaction = Paynl\Transaction::getForExchange();
        $this->assertInstanceOf('\Paynl\Result\Transaction\Transaction', $transaction);
    }

    public function testGetForExchangePost()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/transactionPaid');

        unset($_GET['order_id']);

        $_POST['order_id'] = "645958819Xdd3ea1";

        $transaction = Paynl\Transaction::getForExchange();
        $this->assertInstanceOf('\Paynl\Result\Transaction\Transaction', $transaction);
    }

    public function testRefund()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/refund');
        $refund = \Paynl\Transaction::refund('645958819Xdd3ea1', 5);

        $this->assertInstanceOf('Paynl\Result\Transaction\Refund', $refund);
        $this->assertStringStartsWith('RF-', $refund->getRefundId());
    }

    public function testRefundError()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setExpectedException('\Paynl\Error\Api');

        $this->setDummyData('Result/refundError');
        \Paynl\Transaction::refund('645958819Xdd3ea1', 5, 'Description', new DateTime());
    }

    public function testApprove()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/transactionVerify');

        $transaction = Paynl\Transaction::get('12456789');

        $this->setDummyData('Result/approve');
        $result = $transaction->approve();

        $this->assertEquals(true, $result);
    }

    public function testApprovePaidTransaction()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/transactionPaid');

        $transaction = Paynl\Transaction::get('12456789');

        $this->setDummyData('Result/approve');
        $this->setExpectedException('\Paynl\Error\Error');
        $transaction->approve();
    }

    public function testDecline()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/transactionVerify');

        $transaction = Paynl\Transaction::get('12456789');

        $this->setDummyData('Result/decline');
        $result = $transaction->decline();

        $this->assertEquals(true, $result);
    }

    public function testDeclinePaidTransaction()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setDummyData('Result/transactionPaid');

        $transaction = Paynl\Transaction::get('12456789');

        $this->setDummyData('Result/decline');
        $this->setExpectedException('\Paynl\Error\Error');
        $transaction->decline();
    }

    public function testApproveWithoutTransactionId()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setExpectedException('\Paynl\Error\Required');

        \Paynl\Transaction::approve('');
    }

    public function testDeclineWithoutTransactionId()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setExpectedException('\Paynl\Error\Required');

        \Paynl\Transaction::decline('');
    }
    public function testVoidNoTransactionId()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setExpectedException('\Paynl\Error\Required');
        \Paynl\Transaction::void('');
    }
    public function testVoid()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');
        $this->setDummyData('Result/void');

        $result = \Paynl\Transaction::void('123456789');
        $this->assertEquals(true, $result);
    }
    public function testCaptureNoTransactionId()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $this->setExpectedException('\Paynl\Error\Required');
        \Paynl\Transaction::capture('');
    }
    public function testCapture()
    {
        \Paynl\Config::setApiToken('123456789012345678901234567890');
        $this->setDummyData('Result/capture');

        $result = \Paynl\Transaction::capture('123456789');
        $this->assertEquals(true, $result);
    }
}
