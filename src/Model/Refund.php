<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

use \DateTime;
use \JsonSerializable;

/**
 * Class Refund
 *
 * @package PayNL\Sdk\Model
 */
class Refund implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * @var Amount
     */
    protected $amount;

    /**
     * @var array
     */
    protected $products = [];

    /**
     * @var string
     */
    protected $reason = '';

    /**
     * @var DateTime
     */
    protected $processDate;

    /**
     * @return Amount
     */
    public function getAmount(): Amount
    {
        return $this->amount;
    }

    /**
     * @param Amount $amount
     *
     * @return Refund
     */
    public function setAmount(Amount $amount): Refund
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array $products
     *
     * @return Refund
     */
    public function setProducts(array $products): Refund
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     *
     * @return Refund
     */
    public function setReason(string $reason): Refund
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getProcessDate(): DateTime
    {
        return $this->processDate;
    }

    /**
     * @param DateTime $processDate
     *
     * @return Refund
     */
    public function setProcessDate(DateTime $processDate): Refund
    {
        $this->processDate = $processDate;
        return $this;
    }
}
