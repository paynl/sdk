<?php

declare(strict_types=1);

namespace PayNL\Sdk\Util;

/**
 * Class Text
 *
 * @package PayNL\Sdk\Util
 */
class Text
{
    /**
     * @param string $address
     *
     * @return array
     */
    public function splitAddress(string $address): array
    {
        $address = trim($address);
        $addressParts = preg_split('/(\s+)(\d+)/', $address, 2, PREG_SPLIT_DELIM_CAPTURE);

        $street = trim(array_shift($addressParts));
        $number = trim(implode('', $addressParts));

        if (true === empty($street) || true === empty($number)) {
            $addressParts = preg_split('/([A-z]{2,})/', $address, 2, PREG_SPLIT_DELIM_CAPTURE);

            $street = trim(array_shift($addressParts));
            $number = trim(implode('', $addressParts));
        }

        $number = substr($number, 0, 45);

        return compact('street', 'number');
    }
}
