<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\{
    Exception\InvalidArgumentException,
    Exception\MissingParamException,
    Request\AbstractRequest,
    Request\Parameter\TransactionIdTrait
};

/**
 * Class StatusChange
 *
 * @package PayNL\Sdk\Request\Transactions
 */
abstract class AbstractStatusChange extends AbstractRequest
{
    protected const STATUS_APPROVE   = 'approve';
    protected const STATUS_CAPTURE   = 'capture';
    protected const STATUS_DECLINE   = 'decline';
    protected const STATUS_VOID      = 'void';

    use TransactionIdTrait;

    /**
     * @var string
     */
    protected $status;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        $transactionId = (string)$this->getParam('transactionId');
        if (null === $transactionId) {
            throw new MissingParamException('Missing param!');
        }
        $this->setTransactionId($transactionId);
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return "transactions/{$this->getTransactionId()}/{$this->getStatus()}";
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_PATCH;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractStatusChange
     */
    protected function setStatus(string $status): self
    {
        $statusConstants = [
            static::STATUS_APPROVE,
            static::STATUS_CAPTURE,
            static::STATUS_DECLINE,
            static::STATUS_VOID,
        ];

        if (true === in_array($status, $statusConstants, true)) {
            $this->status = $status;
            return $this;
        }

        throw new InvalidArgumentException(
            sprintf(
                'Status "%s" is prohibited',
                $status
            )
        );
    }
}
