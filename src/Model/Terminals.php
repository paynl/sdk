<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Countable, ArrayAccess, IteratorAggregate, ArrayIterator;

/**
 * Class Terminals
 *
 * @package PayNL\Sdk\Model
 */
class Terminals implements ModelInterface, Countable, ArrayAccess, IteratorAggregate
{
    use LinksTrait;

    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @var array
     */
    protected $terminals = [];

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     *
     * @return Terminals
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return array
     */
    public function getTerminals(): array
    {
        return $this->terminals;
    }

    /**
     * @param array $terminals
     *
     * @return Terminals
     */
    public function setTerminals(array $terminals): self
    {
        if (0 === count($terminals)) {
            return $this;
        }

        foreach ($terminals as $terminal) {
            $this->addTerminal($terminal);
        }

        return $this;
    }

    /**
     * @param Terminal $terminal
     *
     * @return Terminals
     */
    public function addTerminal(Terminal $terminal): self
    {
        $this->terminals[$terminal->getId()] = $terminal;
        $this->total++;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->terminals);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->terminals[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->terminals[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->addTerminal($value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->terminals[$offset]);
        $this->total--;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->terminals);
    }
}
