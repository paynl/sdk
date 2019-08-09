<?php
declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;
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
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, AddressModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

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
