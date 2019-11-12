<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Vouchers;

use PayNL\Sdk\{
    Request\AbstractRequest,
    Transformer\TransformerInterface,
    Transformer\Simple as SimpleTransformer
};
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
     * @param string $pinCode
     */
    public function __construct(string $cardNumber, string $pinCode)
    {
        $this->setCardNumber($cardNumber)
            ->setBody((object)[
                'pinCode' => $pinCode
            ]);
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

    /**
     * @return SimpleTransformer
     */
    public function getTransformer(): TransformerInterface
    {
        return new SimpleTransformer();
    }
}
