<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Vouchers;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Model\Voucher,
    Transformer\TransformerInterface,
    Transformer\NoContent as NoContentTransformer
};
use PayNL\Sdk\Request\Parameter\CardNumberTrait;

/**
 * Class Activate
 *
 * @package PayNL\Sdk\Request\Voucher
 */
class Activate extends AbstractRequest
{
    use CardNumberTrait;

    /**
     * Activate constructor.
     *
     * @param string $cardNumber
     * @param Voucher $voucher
     */
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
        return "vouchers/{$this->getCardNumber()}/activate";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }

    /**
     * @return NoContentTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new NoContentTransformer();
    }
}
