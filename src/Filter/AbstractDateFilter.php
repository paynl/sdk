<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use \DateTime;
use \Exception;
use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class AbstractDateFilter
 *
 * @package PayNL\Sdk\Filter
 */
abstract class AbstractDateFilter extends AbstractScalarFilter
{
    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function __construct($value)
    {
        if (true === is_string($value)) {
            $value = new DateTime($value);
        } elseif (false === ($value instanceof DateTime)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expects argument given to be a string or DateTime object, %s given',
                    __METHOD__,
                    true === is_object($value) ? get_class($value) : gettype($value)
                )
            );
        }
        /** @var DateTime $value */
        $value = $value->format('Y-m-d');

        parent::__construct($value);
    }
}
