<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Validator\ObjectInstance as ObjectInstanceValidator,
    Model\Links as LinksModel
};
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
        // nasty construction to prevent unused parameter notification from PHPStan
        $underscoreSeparatedKeys = $underscoreSeparatedKeys === true ? false : $underscoreSeparatedKeys;
        $methodExistsCheck       = $methodExistsCheck === false ?: true;

        // override the given params
        parent::__construct($underscoreSeparatedKeys, $methodExistsCheck);
    }

    public function hydrate(array $data, $object)
    {
        if (true === array_key_exists('_links', $data) && false === ($data['_links'] instanceof LinksModel)) {
            $data['links'] = (new Links())->hydrate($data['_links'], new LinksModel());
            unset($data['_links']);
        }

        return parent::hydrate($data, $object);
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
