<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use DateTime as stdDateTime;
use PayNL\Sdk\{
    Common\DateTime,
    Common\DebugAwareInterface,
    Common\DebugAwareTrait,
    Exception\InvalidArgumentException,
    Hydrator\Manager as HydratorManager,
    Model\Manager as ModelManager,
    Validator\ValidatorManagerAwareInterface,
    Validator\ValidatorManagerAwareTrait
};
use Zend\Hydrator\ClassMethods;

/**
 * Class AbstractHydrator
 *
 * @package PayNL\Sdk\Hydrator
 */
abstract class AbstractHydrator extends ClassMethods implements DebugAwareInterface, ValidatorManagerAwareInterface
{
    use DebugAwareTrait, ValidatorManagerAwareTrait;

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
        $data = array_filter($data, static function ($item) {
            return null !== $item;
        });

        return parent::hydrate($data, $object);
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
