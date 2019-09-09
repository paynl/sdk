<?php
declare(strict_types=1);

namespace PayNL\Sdk\Model;

use \JsonSerializable;

/**
 * Class Amount
 *
 * @package PayNL\Sdk\Model
 */
class Amount implements ModelInterface, JsonSerializable
{
    use JsonSerializeTrait;

    // TODO: adjust documentation should be an integer
    /**
     * Amount in cents
     *
     * @var integer
     */
    protected $amount = 0;

    /**
     * @var string
     */
    protected $currency = 'EUR';

    /**
     * @return integer
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param integer $amount
     *
     * @return Amount
     */
    public function setAmount(?int $amount): Amount
    {
        if (null !== $amount) {
            $this->amount = $amount;
        }
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
