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

    public function testCalculateTaxClassN()
    {
        $calculatedTaxClass = \Paynl\Helper::calculateTaxClass(10, 0);
        $this->assertEquals('N', $calculatedTaxClass);
    }

    public function testCalculateTaxClassL()
    {
        $calculatedTaxClass = \Paynl\Helper::calculateTaxClass(10, 0.5);
        $this->assertEquals('L', $calculatedTaxClass);
    }

    public function testCalculateTaxClassH()
    {
        $calculatedTaxClass = \Paynl\Helper::calculateTaxClass(10, 1.74);
        $this->assertEquals('H', $calculatedTaxClass);
    }

    public function testSplitAddress()
    {
        // @todo Test more types of addresses here
        $splittedAddress = \Paynl\Helper::splitAddress('Voorstraat 2');

        $this->assertEquals(array(
            'Voorstraat',
            '2'
        ), $splittedAddress);
    }
    public function testObjectToArray()
    {
        $object = (object)['a' => '1', 'b' => '2', 'c' => '3', 'd' => '4'];
        $array = \Paynl\Helper::objectToArray($object);

        $this->assertInternalType('array', $array);
    }


}
