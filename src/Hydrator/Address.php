<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Address as AddressModel;

/**
 * Class Address
 *
 * @package PayNL\Sdk\Hydrator
 */
class Address extends ClassMethods
{
    /**
     * @inheritDoc
     *
     * @return AddressModel
     */
    public function hydrate(array $data, $object): AddressModel
    {
        // TODO: ask Mike which keys are really optional
        foreach (['initials', 'lastName', 'streetName', 'streetNumber', 'streetNumberExtension', 'zipCode', 'city', 'regionCode', 'countryCode'] as $optionalKey) {
            if (false === array_key_exists($optionalKey, $data) || true === empty($data[$optionalKey])) {
                $data[$optionalKey] = '';
            }
        }

        /** @var AddressModel $address */
        $address = parent::hydrate($data, $object);
        return $address;
    }
}
