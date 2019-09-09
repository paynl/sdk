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
     * AbstractFilter constructor.
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException when given argument is not a string nor an integer
     */
    public function __construct($value)
    {
        if (true === is_int($value)) {
            $value = (string)$value;
        } elseif (false === is_string($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s expects argument given to be a string or an integer, %s given',
                    __METHOD__,
                    is_object($value) === true ? get_class($value) : gettype($value)
                )
            );
        }
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return AbstractScalar
     */
    public function setValue(string $value): self
    {
        $this->value = $value;
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
