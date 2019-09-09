<?php
declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use \DateTime;
use \Exception;
use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class AbstractDate
 *
 * @package PayNL\Sdk\Filter
 */
abstract class AbstractDate extends AbstractScalar
{
    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException when given argument is not a string nor a DateTime object
     */
    public function __construct($value)
    {
        if (true === is_string($value)) {
            try {
                $value = new DateTime($value);
            } catch (Exception $e) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Can not convert "%s" to a %s object',
                        $value,
                        DateTime::class
                    )
                );
            }
        } elseif (false === ($value instanceof DateTime)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expects argument given to be a string or DateTime object, %s given',
                    __METHOD__,
                    is_object($value) === true ? get_class($value) : gettype($value)
                )
            );
        }
        /** @var DateTime $value */
        $value = $value->format('Y-m-d');

        parent::__construct($value);
    }
}
