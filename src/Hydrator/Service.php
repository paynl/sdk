<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\DateTime;
use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\Model\Service as ServiceModel;

/**
 * Class Service
 *
 * @package PayNL\Sdk\Hydrator
 */
class Service extends ClassMethods
{
    /**
     * Address constructor.
     *
     * @param bool $underscoreSeparatedKeys
     * @param bool $methodExistsCheck
     */
    public function __construct($underscoreSeparatedKeys = true, $methodExistsCheck = false)
    {
        // override the given params
        parent::__construct(false, true);
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException when the given object is not an instance of the Service model
     *
     * @return ServiceModel
     */
    public function hydrate(array $data, $object): ServiceModel
    {
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, ServiceModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

        $data['description'] = $data['description'] ?? '';
        $data['testMode']    = $data['testMode'] ?? 0;
        $data['secret']      = $data['secret'] ?? '';

        $dateField = 'createdAt';
        if (true === array_key_exists($dateField, $data)) {
            $createdDate = $data[$dateField];
            if ($createdDate instanceof DateTime) {
                $createdDate = $createdDate->format(DateTime::ATOM);
            }
            $data[$dateField] = empty($data[$dateField]) === true ? null : DateTime::createFromFormat(DateTime::ATOM, $createdDate);
        }

        /** @var ServiceModel $service */
        $service = parent::hydrate($data, $object);
        return $service;
    }
}
