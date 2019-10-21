<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Countable, ArrayAccess, IteratorAggregate, ArrayIterator;

/**
 * Class Currencies
 *
 * @package PayNL\Sdk\Model
 */
class Currencies implements ModelInterface, Countable, ArrayAccess, IteratorAggregate
{
    use LinksTrait;

    /**
     * @var integer
     */
    protected $total;

    /**
     * @var array
     */
    protected $currencies = [];

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
     * @return Currencies
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return array
     */
    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    /**
     * @param array $currencies
     *
     * @return Currencies
     */
    public function setCurrencies(array $currencies): self
    {
        if (0 === count($currencies)) {
            return $this;
        }

        foreach ($currencies as $currency) {
            $this->addCurrency($currency);
        }

        return $this;
    }

    /**
     * @param Currency $currency
     *
     * @return Currencies
     */
    public function addCurrency(Currency $currency): self
    {
        $this->currencies[$currency->getAbbreviation()] = $currency;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->currencies);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->currencies[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->currencies[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->addCurrency($value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->currencies[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->getTotal();
    }
}
