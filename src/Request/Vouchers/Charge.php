<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Vouchers;

use PayNL\Sdk\Model\Voucher;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\CardNumberTrait;

/**
 * Class Charge
 *
 * @package PayNL\Sdk\Request\Voucher
 */
class Charge extends AbstractRequest
{
    use CardNumberTrait;

    public function __construct(string $cardNumber, Voucher $voucher)
    {
        $this->setCardNumber($cardNumber)
            ->setBody($voucher)
        ;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "vouchers/{$this->getCardNumber()}/charge";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }
}
