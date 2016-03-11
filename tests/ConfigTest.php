<?php

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testCAInfoLocation()
    {
        \Paynl\Config::setCAInfoLocation('test/location');

        $this->assertEquals('test/location',
            \Paynl\Config::getCAInfoLocation());
    }

    public function testApiToken()
    {
        \Paynl\Config::setApiToken('my-api-token');

        $this->assertEquals('my-api-token', \Paynl\Config::getApiToken());
    }

    public function testServiceId()
    {
        \Paynl\Config::setServiceId('my-service-id');

        $this->assertEquals('my-service-id', \Paynl\Config::getServiceId());
    }

    public function testApiVersion()
    {
        \Paynl\Config::setApiVersion(4);

        $this->assertEquals(4, \Paynl\Config::getApiVersion());
    }

    public function testApiUrl()
    {
        \Paynl\Config::setApiVersion(4);

        $this->assertEquals(
            'https://rest-api.pay.nl/v4/transaction/json',
            \Paynl\Config::getApiUrl('transaction')
        );
    }
    public function testGetCurlDefault(){
        $this->assertInstanceOf('\Curl\Curl', \Paynl\Config::getCurl());
    }
    public function testGetCurlCustom(){
        \Paynl\Config::setCurl(new DateTime());
        $this->assertInstanceOf('\DateTime', \Paynl\Config::getCurl());
    }
}
