<?php

/**
 * Created by PhpStorm.
 * User: andy
 * Date: 15-4-2016
 * Time: 16:22
 */
class PaymentmethodsTest extends PHPUnit_Framework_TestCase
{
    private $testApiResult;


    private function setDummyData(){
        $this->testApiResult = file_get_contents(dirname(dirname(__FILE__)).'/dummyData/getService.json');
        \Paynl\Config::setCurl(new \Paynl\Curl\Dummy($this->testApiResult));
    }

    public function testGetPaymentMethodsNoServiceId(){
        $this->setDummyData();
        \Paynl\Config::setApiToken('123456789012345678901234567890');
        \Paynl\Config::setServiceId('');
        $this->setExpectedException('\Paynl\Error\Required\ServiceId');
        \Paynl\Paymentmethods::getList();

    }
    public function testGetPaymentMethodsNoToken(){
        $this->setDummyData();
        \Paynl\Config::setApiToken('');
        \Paynl\Config::setServiceId('SL-1234-5678');
        $this->setExpectedException('\Paynl\Error\Required\Apitoken');
        \Paynl\Paymentmethods::getList();
    }
    public function testGetPaymentMethods(){
        $this->setDummyData();

        \Paynl\Config::setServiceId('SL-1234-5678');
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $list = \Paynl\Paymentmethods::getList();

        $this->assertInternalType('array',$list);

        foreach($list as $paymentMethod){
            $this->assertArrayHasKey('id', $paymentMethod);
            $this->assertArrayHasKey('name', $paymentMethod);
            $this->assertArrayHasKey('visibleName', $paymentMethod);
        }
    }

    public function testGetBanksNoToken(){
        $this->setExpectedException('\Paynl\Error\Required\Apitoken');
        $this->setDummyData();

        \Paynl\Config::setServiceId('SL-1234-5678');
        \Paynl\Config::setApiToken('');

        \Paynl\Paymentmethods::getBanks();
    }

    public function testGetBanksNoServiceId(){
        $this->setExpectedException('\Paynl\Error\Required\ServiceId');
        $this->setDummyData();

        \Paynl\Config::setServiceId('');
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        \Paynl\Paymentmethods::getBanks();
    }

    public function testGetBanks(){
        $this->setDummyData();

        \Paynl\Config::setServiceId('SL-1234-5678');
        \Paynl\Config::setApiToken('123456789012345678901234567890');

        $banks = \Paynl\Paymentmethods::getBanks();

        $this->assertInternalType('array',$banks);

        foreach($banks as $bank){
            $this->assertArrayHasKey('id', $bank);
            $this->assertArrayHasKey('name', $bank);
            $this->assertArrayHasKey('visibleName', $bank);
        }
    }
}
