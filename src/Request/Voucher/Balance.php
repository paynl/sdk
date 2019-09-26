<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Voucher;

use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\CardNumberTrait;

/**
 * Class Balance
 *
 * @package PayNL\Sdk\Request\Voucher
 */
class Balance extends AbstractRequest
{
    use CardNumberTrait;

    /**
     * Balance constructor.
     *
     * @param string $cardNumber
     */
    public function __construct(string $cardNumber)
    {
        $this->setCardNumber($cardNumber);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "vouchers/{$this->getCardNumber()}/balance";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }
}
