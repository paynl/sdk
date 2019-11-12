<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class Interval
 *
 * @package PayNL\Sdk\Model
 */
class Interval implements ModelInterface
{
    /**
     * @var string
     */
    protected $period;

    /**
     * @var integer
     */
    protected $quantity;

    /**
     * @var integer
     */
    protected $value;

    /**
     * @return string
     */
    public function getPeriod(): string
    {
        return $this->period;
    }

    /**
     * @param string $period
     *
     * @return Interval
     */
    public function setPeriod(string $period): self
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return Interval
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     *
     * @return Interval
     */
    public function setValue(int $value): self
    {
        $this->value = $value;
        return $this;
    }
}
