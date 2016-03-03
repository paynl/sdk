<?php

class HelperTest extends PHPUnit_Framework_TestCase
{
    public function testRequireApiTokenException()
    {
        $this->expectException(\Paynl\Error\Required\ApiToken::class);

        \Paynl\Config::setApiToken('');
        \Paynl\Helper::requireApiToken();
    }

    public function testRequireServiceIdException()
    {
        $this->expectException(\Paynl\Error\Required\ServiceId::class);

        \Paynl\Config::setServiceId('');
        \Paynl\Helper::requireServiceId();
    }

    public function testCalculateTaxClass()
    {
        $calculatedTaxClass = \Paynl\Helper::calculateTaxClass(10, 0.6);

        $this->assertEquals('L', $calculatedTaxClass);
    }
}
