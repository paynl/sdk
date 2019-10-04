<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Model\Address as AddressModel;

/**
 * Class Address
 *
 * @package PayNL\Sdk\Hydrator
 */
class Address extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return AddressModel
     */
    public function hydrate(array $data, $object): AddressModel
    {
        $this->validateGivenObject($object, AddressModel::class);

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
