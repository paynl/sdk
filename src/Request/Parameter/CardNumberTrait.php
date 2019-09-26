<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Parameter;

/**
 * Trait CardNumberTrait
 *
 * @package PayNL\Sdk\Request\Parameter
 */
trait CardNumberTrait
{
    /**
     * @var string
     */
    protected $cardNumber;

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     *
     * @return CardNumberTrait
     */
    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }
}
