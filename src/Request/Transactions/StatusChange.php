<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Exception\InvalidArgumentException;
use PayNL\Sdk\Request\AbstractRequest;
use PayNL\Sdk\Request\Parameter\TransactionIdTrait;

/**
 * Class StatusChange
 *
 * @package PayNL\Sdk\Request\Transactions
 */
abstract class StatusChange extends AbstractRequest
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
    public function getUri(): string
    {
        return "transactions/{$this->getTransactionId()}/{$this->getStatus()}";
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
     * @return StatusChange
     */
    public function setStatus(string $status): self
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
