<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Validator\ObjectInstance as ObjectInstanceValidator;
use Zend\Hydrator\ClassMethods;

/**
 * Class AbstractHydrator
 *
 * @package PayNL\Sdk\Hydrator
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractHydrator extends ClassMethods
{
    /**
     * AbstractHydrator constructor.
     *
     * @param bool $underscoreSeparatedKeys
     * @param bool $methodExistsCheck
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function __construct($underscoreSeparatedKeys = true, $methodExistsCheck = false)
    {
        // override the given params
        parent::__construct(false, true);
    }

    /**
     * @param object $object
     * @param string $shouldBeInstanceOf
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    protected function validateGivenObject($object, string $shouldBeInstanceOf): void
    {
        $instanceValidator = new ObjectInstanceValidator();
        if (false === $instanceValidator->isValid($object, $shouldBeInstanceOf)) {
            throw new InvalidArgumentException(
                implode(PHP_EOL, $instanceValidator->getMessages())
            );
        }
    }
}
