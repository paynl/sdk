<?php

class RefundTest extends PHPUnit_Framework_TestCase
{
    private $testApiResult;

    private function setDummyData($name)
    {
        $this->testApiResult = file_get_contents(__DIR__ . '/dummyData/Refund/' . $name . '.json');
        $curl = new \Paynl\Curl\Dummy();
        $curl->setResult($this->testApiResult);
        \Paynl\Config::setCurl($curl);
    }

    private function refundAddFull(){
        return \Paynl\Refund::add([
            'amount' => 1,
            'bankAccountHolder' => 'N Klant',
            'bankAccountNumber' => '123456789',
            'bankAccountBic' => '123456789',
            'description' => 'description',
            'promotorId' => '1',
            'info' => '1',
            'tool' => '1',
            'object' => '1',
            'extra1' => '1',
            'extra2' => '1',
            'extra3' => '1',
            'orderId' => '1',
            'currency' => '1',
            'processDate' => '12-12-2017',
        ]);
    }

    public function testRefundAddNoServiceId(){
        $this->setDummyData('refund');
        $this->setExpectedException(\Paynl\Error\Required\ServiceId::class);

        \Paynl\Config::setApiToken('123456789012345678901234567890');
        \Paynl\Config::setServiceId('');

        $this->refundAddFull();
    }

    public function testRefundAddNoToken(){
        $this->setDummyData('refund');
        $this->setExpectedException(\Paynl\Error\Required\ApiToken::class);

        \Paynl\Config::setApiToken('');
        \Paynl\Config::setServiceId('SL-1234-5678');

        $this->refundAddFull();
    }

    public function testRefundAdd(){
        $this->setDummyData('refund');
        \Paynl\Config::setApiToken('123456789012345678901234567890');
        \Paynl\Config::setServiceId('SL-1234-5678');
        $result = $this->refundAddFull();
        $this->assertInstanceOf(\Paynl\Result\Refund\Add::class, $result);
        $this->assertStringStartsWith('RF-',$result->getRefundId());
    }
}