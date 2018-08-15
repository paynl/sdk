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
        // @todo Straatnamen met een nummer er in bijvoorbeeld: Boulevard 1945
        $addresses = array(
            array('Voorstraat 2', 'Voorstraat', '2'),
            array('Kopersteden 10', 'Kopersteden', '10'),
            array('Kopersteden 10A', 'Kopersteden', '10A'),
            array('Kopersteden 10 A', 'Kopersteden', '10 A'),
            array('Kopersteden 10-A', 'Kopersteden', '10-A'),
            array('25 American street', 'American street', '25'),
            array('1e Wereldoorlogweg 12', '1e Wereldoorlogweg', '12'),
            array('Lang huisnummer 1234567890', 'Lang huisnummer', '1234567890'),
            array('2e Bothofdwarsstraat 2-44', '2e Bothofdwarsstraat', '2-44'),
            array('Straat 145-Boven', 'Straat', '145-Boven'),
            array('Appartementenweg 12-786', 'Appartementenweg', '12-786'),
            array('Appartementenweg 3 hoog achter', 'Appartementenweg', '3 hoog achter'),
            array('driesplein 22/2', 'driesplein', '22/2'),
        );

        foreach ($addresses as $address) {
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
