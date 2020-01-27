<?php

declare(strict_types=1);

namespace PayNL\Sdk\Config;

use Countable,
    Iterator,
    ArrayAccess
;
use PayNL\Sdk\Exception\UnexpectedValueException;

/**
 * Class Config
 *
 * @package PayNL\Sdk
 */
class Config implements Countable, Iterator, ArrayAccess
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Config constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (false === is_string($key) && false === is_int($key)) {
                throw new UnexpectedValueException(
                    'Keys in the configuration must be a string or integer'
                );
            }

            if (true === is_array($value)) {
                $value = new self($value);
            }
            $this->data[$key] = $value;
        }
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $data = [];

        foreach ($this->data as $key => $value) {
            if ($value instanceof self) {
                $value = clone $value;
            }
            $data[$key] = $value;
        }
        
        $this->data = $data;
    }

    /**
     * @param string|int $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * @param string|int $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param string|int $key
     * @param mixed $value
     *
     * @return void
     */
    public function set($key, $value): void
    {
        if (true === is_array($value)) {
            $value = new self($value);
        }
        
        $this->data[$key] = $value;
    }

    /**
     * @param string|int $key
     * @param mixed $value
     *
     * @return void
     */
    public function __set($key, $value): void
    {
        $this->set($key, $value);
    }

    /**
     * @param string|int $key
     *
     * @return void
     */
    public function remove($key): void
    {
        if (true === $this->has($key)) {
            unset($this->data[$key]);
        }
    }

    /**
     * @param string|int $key
     *
     * @return void
     */
    public function __unset($key): void
    {
        $this->remove($key);
    }

    /**
     * @param string|int $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @param string|int $key
     *
     * @return bool
     */
    public function __isset($key): bool
    {
        return $this->has($key);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        $data = $this->data;

        foreach ($data as $key => $value) {
            if ($value instanceof self) {
                $value = $value->toArray();
            }
            $array[$key] = $value;
        }

        return $array;
    }

    /**
     * @inheritDoc
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function next(): void
    {
        next($this->data);
    }

    /**
     * @inheritDoc
     * 
     * @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * @inheritDoc
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return null !== $this->key();
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function rewind(): void
    {
        reset($this->data);
    }

    /**
     * @inheritDoc
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @inheritDoc
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Merge the current config object with the given one
     *
     * @param Config $mergeConfig
     *
     * @return Config
     */
    public function merge(Config $mergeConfig): self
    {
        foreach ($mergeConfig as $key => $value) {
            $currentValue = $this->get($key);
            if ($value instanceof self && $currentValue instanceof self) {
                $value = $currentValue->merge($value);
            }
            $this->set($key, $value);
        }

        return $this;
    }
}
