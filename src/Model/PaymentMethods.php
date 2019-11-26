<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Countable, ArrayAccess, IteratorAggregate, ArrayIterator;

/**
 * Class PaymentMethods
 *
 * @package PayNL\Sdk\Model
 */
class PaymentMethods implements ModelInterface, Countable, ArrayAccess, IteratorAggregate
{
    use LinksTrait;

    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @var array
     */
    protected $paymentMethods = [];

    /**
     * @return integer
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param integer $total
     *
     * @return PaymentMethods
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return $this->paymentMethods;
    }

    /**
     * @param array $paymentMethods
     *
     * @return PaymentMethods
     */
    public function setPaymentMethods(array $paymentMethods): self
    {
        if (0 === count($paymentMethods)) {
            return $this;
        }

        // reset the total
        $this->total = 0;

        foreach ($paymentMethods as $paymentMethod) {
            $this->addPaymentMethod($paymentMethod);
        }
        return $this;
    }

    public function addPaymentMethod(PaymentMethod $paymentMethod): self
    {
        $this->paymentMethods[$paymentMethod->getId()] = $paymentMethod;
        $this->total++;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->paymentMethods);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->paymentMethods[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->paymentMethods[$offset] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->addPaymentMethod($value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->paymentMethods[$offset]);
        $this->total--;
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->paymentMethods);
    }
}
