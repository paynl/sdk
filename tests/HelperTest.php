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
        $addresses = array(
            array('Voorstraat 2', 'Voorstraat', '2'),
            array('Kopersteden 10', 'Kopersteden', '10'),
            array('Kopersteden 10 A', 'Kopersteden', '10 A'),
            array('25 American street', 'American street', '25'),
            array('1e Wereldoorlogweg 12', '1e Wereldoorlogweg', '12'),
            array('Lang huisnummer 1234567890', 'Lang huisnummer', '1234567890'),

        );

        foreach($addresses as $address){
            $arrAddress = \Paynl\Helper::splitAddress($address[0]);

            $this->assertEquals(array(
                $address[1],
                $address[2]
            ), $arrAddress);
        }

    }
    public function testObjectToArray()
    {
        $object = (object)array('a' => '1', 'b' => '2', 'c' => '3', 'd' => '4');
        $array = \Paynl\Helper::objectToArray($object);

        $this->assertInternalType('array', $array);
    }


}
