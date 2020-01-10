<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use DateTime as stdDateTime;
use PayNL\Sdk\{
    Common\DateTime,
    Exception\InvalidArgumentException,
    Validator\ObjectInstance as ObjectInstanceValidator,
    Model\Links as LinksModel,
    Hydrator\Manager as HydratorManager,
    Model\Manager as ModelManager
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
     * @var HydratorManager
     */
    protected $hydratorManager;

    /**
     * @var ModelManager
     */
    protected $modelManager;

    /**
     * AbstractHydrator constructor.
     *
     * @param HydratorManager $hydratorManager
     * @param ModelManager $modelManager
     * @param bool $underscoreSeparatedKeys
     * @param bool $methodExistsCheck
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function __construct(HydratorManager $hydratorManager, ModelManager $modelManager, $underscoreSeparatedKeys = true, $methodExistsCheck = false)
    {
        $this->hydratorManager = $hydratorManager;
        $this->modelManager = $modelManager;

        // nasty construction to prevent unused parameter notification from PHPStan
        $underscoreSeparatedKeys = $underscoreSeparatedKeys === true ? false : $underscoreSeparatedKeys;
        $methodExistsCheck       = $methodExistsCheck === false ?: true;

        // override the given params
        parent::__construct($underscoreSeparatedKeys, $methodExistsCheck);
    }

    /**
     * @inheritDoc
     *
     * @internal also automatically sets links and filters to remove all null values
     */
    public function hydrate(array $data, $object)
    {
        $linksModel = $this->modelManager->build('Links');

        if (true === array_key_exists('_links', $data) && false === ($data['_links'] instanceof $linksModel)) {
            $data['links'] = $this->hydratorManager->build('Links')->hydrate($data['_links'], $linksModel);
            unset($data['_links']);
        }

        $data = array_filter($data, static function ($item) {
            return null !== $item;
        });

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

    /**
     * @param string|stdDateTime $dateTime
     *
     * @return DateTime
     */
    protected function getSdkDateTime($dateTime): DateTime
    {
        if ($dateTime instanceof DateTime) {
            return $dateTime;
        }

        if ($dateTime instanceof stdDateTime) {
            $dateTime = $dateTime->format(stdDateTime::ATOM);
        }
        return DateTime::createFromFormat(DateTime::ATOM, $dateTime);
    }
}
