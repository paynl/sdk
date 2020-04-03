<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use PayNL\Sdk\Exception\InvalidArgumentException;

/**
 * Class AbstractFilter
 *
 * @package PayNL\Sdk\Filter
 */
abstract class AbstractScalar implements FilterInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @inheritDoc
     */
    public function __construct($value = null)
    {
        if (null !== $value) {
            $this->setValue($value);
        }
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidArgumentException when given argument is not a string nor an integer
     */
    public function setValue($value): FilterInterface
    {
        $exception = new InvalidArgumentException(
            sprintf(
                '%s expects argument given to be scalar, %s given',
                __METHOD__,
                gettype($value)
            )
        );

        if (false === is_scalar($value)) {
            throw $exception;
        }

        switch (gettype($value)) {
            case 'boolean':
                $value = (string)(int)$value;
                break;
            case 'integer':
            case 'double':
                // for historical reasons the gettype of float is
                //  "double" (https://www.php.net/manual/en/function.gettype.php)
                $value = (string)$value;
                break;
            case 'string':
                // do nothing
                break;
        }

        $this->value = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName() . '=' . $this->getValue();
    }
}
