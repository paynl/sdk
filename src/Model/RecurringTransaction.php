<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class RecurringTransaction
 *
 * @package PayNL\Sdk\Model
 */
class RecurringTransaction implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var Amount
     */
    protected $amount;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $extra1;

    /**
     * @var string
     */
    protected $extra2;

    /**
     * @var string
     */
    protected $extra3;

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        if (null === $this->amount) {
            $this->setAmount(new Amount());
        }
        return $this->amount;
    }

    /**
     * @param Amount $amount
     *
     * @return RecurringTransaction
     */
    public function setAmount(Amount $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->description;
    }

    /**
     * @param string $description
     *
     * @return RecurringTransaction
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtra1(): string
    {
        return (string)$this->extra1;
    }

    /**
     * @param string $extra1
     *
     * @return RecurringTransaction
     */
    public function setExtra1(string $extra1): self
    {
        $this->extra1 = $extra1;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtra2(): string
    {
        return (string)$this->extra2;
    }

    /**
     * @param string $extra2
     *
     * @return RecurringTransaction
     */
    public function setExtra2(string $extra2): self
    {
        $this->extra2 = $extra2;
        return $this;
    }

    /**
     * @return string
     */
    public function getExtra3(): string
    {
        return (string)$this->extra3;
    }

    /**
     * @param string $extra3
     *
     * @return RecurringTransaction
     */
    public function setExtra3(string $extra3): self
    {
        $this->extra3 = $extra3;
        return $this;
    }
}
