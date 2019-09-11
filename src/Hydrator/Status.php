<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;
use Zend\Hydrator\ClassMethods;
use PayNL\Sdk\DateTime;
use PayNL\Sdk\Model\Status as StatusModel;

/**
 * Class Status
 *
 * @package PayNL\Sdk\Hydrator
 */
class Status extends ClassMethods
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
     * @throws InvalidArgumentException when given object is not an instance of Status model
     *
     * @return StatusModel
     */
    public function hydrate(array $data, $object): StatusModel
    {
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, StatusModel::class)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }

        if (true === array_key_exists('date', $data)) {
            $date = $data['date'];
            if ($date instanceof DateTime) {
                $date = $date->format(DateTime::ATOM);
            }
            $data['date'] = empty($data['date']) === true ? null : DateTime::createFromFormat(DateTime::ATOM, $date);
        }

        if (false === array_key_exists('reason', $data) || true === empty($data['reason'])) {
            $data['reason'] = '';
        }

        /** @var StatusModel $status */
        $status = parent::hydrate($data, $object);
        return $status;
    }
}
