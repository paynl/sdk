<?php

use Paynl\Merchant;

class MerchantTest extends PHPUnit_Framework_TestCase
{
    private $testApiResult;
    private function setDummyData($filename)
    {
        $filename            = __DIR__ . '/dummyData/Merchant/' . $filename;
        $this->testApiResult = file_get_contents($filename);

        $curl = new \Paynl\Curl\Dummy();
        $curl->setResult($this->testApiResult);

        \Paynl\Config::setCurl($curl);
    }

    public function testAddTradeNameWithoutToken()
    {
        \Paynl\Config::setApiToken('');

        $this->setExpectedException('\Paynl\Error\Required\ApiToken');

        Merchant::addTradeName('Some tradename');
    }

    public function testAddTradeNameEmpty()
    {
        $this->setDummyData('addTrademark.json');
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $this->setExpectedException('\Paynl\Error\Required');

        Merchant::addTradeName('');
    }


    public function testAddTradeName()
    {
        $this->setDummyData('addTrademark.json');
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $result = Merchant::addTradeName('Some tradename');
        $this->assertStringMatchesFormat('TM-%d-%d', $result);
    }

    public function testAddTradeNameError()
    {
        $this->setDummyData('addTrademarkError.json');
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $this->setExpectedException('\Paynl\Error\Api');

        Merchant::addTradeName('Some tradename');
    }

    public function testDeleteTradeNameWithoutToken()
    {
        \Paynl\Config::setApiToken('');

        $this->setExpectedException('\Paynl\Error\Required\ApiToken');

        Merchant::deleteTradeName('TM-0123-0987');
    }

    public function testDeleteTradeNameWithoutId()
    {
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $this->setExpectedException('\Paynl\Error\Required');

        Merchant::deleteTradeName('');
    }

    public function testDeleteTradeName()
    {
        $this->setDummyData('deleteTrademark.json');
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $result = Merchant::deleteTradeName('TM-0123-0987');

        $this->assertTrue($result);
    }

    public function testInfoWithoutToken()
    {
        \Paynl\Config::setApiToken('');

        $this->setExpectedException('\Paynl\Error\Required\ApiToken');

        Merchant::info();
    }

    public function testInfoWithoutMerchantError()
    {
        $this->setDummyData('infoError.json');
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $this->setExpectedException('\Paynl\Error\Api');
        Merchant::info();
    }

    public function testInfoWithoutMerchantId()
    {
        $this->setDummyData('info.json');
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $result = Merchant::info();
        $this->assertInstanceOf('\Paynl\Result\Merchant\Info', $result);
    }

    public function testInfoWithMerchantId()
    {
        $this->setDummyData('info.json');
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $result = Merchant::info('M-1234-9876');
        $this->assertInstanceOf('\Paynl\Result\Merchant\Info', $result);
    }

    public function testGetTradeNames()
    {
        $this->setDummyData('info.json');
        \Paynl\Config::setApiToken('abcdefghijklmnopqrstuvwxys');

        $result = Merchant::getTradeNames();

        $this->assertInternalType('array', $result);
        foreach ($result as $tradeName) {
            $this->assertArrayHasKey('id', $tradeName);
            $this->assertArrayHasKey('name', $tradeName);
        }
    }
}
