<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Countable, ArrayAccess, IteratorAggregate, ArrayIterator;

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

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->errors);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
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
    public function offsetSet($offset, $value): void
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
    public function offsetUnset($offset): void
    {
        unset($this->errors[$offset]);
    }

    /**
     * @inheritDoc
     *
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->errors);
    }
}
