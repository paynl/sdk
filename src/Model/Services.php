<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Countable, ArrayAccess, IteratorAggregate, ArrayIterator;

/**
 * Class Services
 *
 * @package PayNL\Sdk\Model
 */
class Services implements ModelInterface, Countable, ArrayAccess, IteratorAggregate
{
    use LinksTrait;

    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @var array
     */
    protected $services = [];

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
     * @return Services
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @param array $services
     *
     * @return Services
     */
    public function setServices(array $services): self
    {
        if (0 === count($services)) {
            return $this;
        }

        foreach ($services as $service) {
            $this->addService($service);
        }

        return $this;
    }

    /**
     * @param Service $service
     *
     * @return Services
     */
    public function addService(Service $service): self
    {
        $this->services[$service->getId()] = $service;
        $this->total++;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->services);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->services[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->services[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        return $this->addService($value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->services[$offset]);
        $this->total--;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->getTotal();
    }
}
