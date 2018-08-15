<?php

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testCAInfoLocation()
    {
        \Paynl\Config::setCAInfoLocation('test/location');

        $this->assertEquals(
            'test/location',
            \Paynl\Config::getCAInfoLocation()
        );
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
        \Paynl\Config::setApiBase('https://alternative-api.com');

        $this->assertEquals(
            'https://alternative-api.com/v4/transaction/json',
            \Paynl\Config::getApiUrl('transaction')
        );
    }

    public function testGetCurlDefault()
    {
        $this->assertInstanceOf('\Curl\Curl', \Paynl\Config::getCurl());
    }

    public function testGetCurlCustom()
    {
        \Paynl\Config::setCurl(new \Paynl\Curl\Dummy());
        $this->assertInstanceOf('\Paynl\Curl\Dummy', \Paynl\Config::getCurl());
    }

    public function testGetCurlCustomString()
    {
        \Paynl\Config::setCurl('\Paynl\Curl\Dummy');
        $this->assertInstanceOf('\Paynl\Curl\Dummy', \Paynl\Config::getCurl());
    }
}
