<?php

class HelperTest extends PHPUnit_Framework_TestCase
{
    public function testRequireApiTokenException()
    {
        $this->setExpectedException('\Paynl\Error\Required\ApiToken');

        \Paynl\Config::setApiToken('');
        \Paynl\Helper::requireApiToken();
    }

    public function testRequireServiceIdException()
    {
        $this->setExpectedException('\Paynl\Error\Required\ServiceId');

        \Paynl\Config::setServiceId('');
        \Paynl\Helper::requireServiceId();
    }

    public function testCalculateTaxClass()
    {
        $calculatedTaxClass = \Paynl\Helper::calculateTaxClass(10, 0.6);

        $this->assertEquals('L', $calculatedTaxClass);
    }

    public function testSplitAddress()
    {
        $splittedAddress = \Paynl\Helper::splitAddress('Voorstraat 2');

        $this->assertEquals(array(
            'Voorstraat',
            '2'
        ), $splittedAddress);
    }
}
