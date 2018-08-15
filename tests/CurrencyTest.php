<?php

class CurrencyTest extends PHPUnit_Framework_TestCase
{
    private $testApiResult;

    private function setDummyData()
    {
        $this->testApiResult = file_get_contents(__DIR__.'/dummyData/currencies.json');

        $curl = new \Paynl\Curl\Dummy();
        $curl->setResult($this->testApiResult);
        \Paynl\Config::setCurl($curl);
    }

    public function testGetCurrencies()
    {
        \Paynl\Config::setApiToken('1234567894561234567');
        $this->setDummyData();

        $currencies = \Paynl\Currency::getAll();

        $this->assertInternalType('array', $currencies);
    }

    public function testGetCurrencyId()
    {
        \Paynl\Config::setApiToken('1234567894561234567');
        $this->setDummyData();
        $currencyId = \Paynl\Currency::getCurrencyId('EUR');

        $this->assertEquals(1, $currencyId);
    }

    public function testNotFound()
    {
        \Paynl\Config::setApiToken('1234567894561234567');
        $this->setDummyData();

        $this->setExpectedException('\Paynl\Error\NotFound');

        \Paynl\Currency::getCurrencyId('ZZZ');
    }
}
