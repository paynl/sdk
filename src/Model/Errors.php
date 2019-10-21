<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Countable, ArrayAccess, IteratorAggregate, ArrayIterator, Traversable;

/**
 * Class Errors
 *
 * @package PayNL\Sdk\Model
 */
class Errors implements ModelInterface, Countable, ArrayAccess, IteratorAggregate
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     *
     * @return Errors
     */
    public function setErrors(array $errors): Errors
    {
        $this->errors = $errors;
        return $this;
    }

    public function count()
    {
        return count($this->errors);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->errors[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->errors[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->errors[] = $value;
        } else {
            $this->errors[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->errors[$offset]);
    }

    /**
     * @inheritDoc
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->errors);
    }
}
