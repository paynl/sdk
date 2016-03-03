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
        \Paynl\Config::setServiceId('api-version');

        $this->assertEquals('api-version', \Paynl\Config::getServiceId());
    }

    public function testApiUrl()
    {
        $this->assertEquals(
            'https://rest-api.pay.nl/v5/transaction/json',
            \Paynl\Config::getApiUrl('transaction', 5)
        );
    }
}
