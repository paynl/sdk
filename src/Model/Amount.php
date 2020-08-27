<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use JsonSerializable;
use PayNL\Sdk\Common\JsonSerializeTrait;

/**
 * Class Amount
 *
 * @package PayNL\Sdk\Model
 */
class Amount implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    /**
     * Amount in cents
     *
     * @required
     *
     * @var int
     */
    protected $amount = 0;

    /**
     * @required
     *
     * @var string
     */
    protected $currency = 'EUR';

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return Amount
     */
    public function setAmount(int $amount): Amount
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return Amount
     */
    public function setCurrency(string $currency): Amount
    {
        $this->currency = $currency;
        return $this;
    }
}
