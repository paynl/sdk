<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Pin;

use PayNL\Sdk\{
    Exception\MissingParamException,
    Request\AbstractRequest,
    Request\Parameter\TransactionIdTrait
};

/**
 * Class CreatePayment
 *
 * @package PayNL\Sdk\Request\Pin
 */
class PayTransaction extends AbstractRequest
{
    use TransactionIdTrait;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $transactionId = (string)$this->getParam('transactionId');
        if (true === empty($transactionId)) {
            throw new MissingParamException(
                'Missing transaction id'
            );
        }

        $this->setTransactionId($transactionId);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "pin/{$this->getTransactionId()}/payment";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }
}
