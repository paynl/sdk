<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Vouchers;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest,
    Request\Parameter\CardNumberTrait
};

/**
 * Class Activate
 *
 * @package PayNL\Sdk\Request\Voucher
 */
class Activate extends AbstractRequest
{
    use CardNumberTrait;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $cardNumber = (string)$this->getParam('cardNumber');
        if (null === $cardNumber) {
            throw new MissingParamException('Missing param!');
        }
        $this->setCardNumber($cardNumber);
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
}
