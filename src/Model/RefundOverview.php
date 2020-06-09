<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

/**
 * Class RefundOverview
 *
 * @package PayNL\Sdk\Model
 */
class RefundOverview implements ModelInterface
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @var Amount
     */
    protected $amountRefunded;

    /**
     * @var array
     */
    protected $refundedTransactions = [];

    /**
     * @var array
     */
    protected $failedTransactions = [];

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this->description;
    }

    /**
     * @param string $description
     *
     * @return RefundOverview
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getAmountRefunded(): Amount
    {
        if (null === $this->amountRefunded) {
            $this->setAmountRefunded(new Amount());
        }
        return $this->amountRefunded;
    }

    /**
     * @param Amount $amountRefunded
     *
     * @return RefundOverview
     */
    public function setAmountRefunded(Amount $amountRefunded): self
    {
        $this->amountRefunded = $amountRefunded;
        return $this;
    }

    /**
     * @return array
     */
    public function getRefundedTransactions(): array
    {
        return $this->refundedTransactions;
    }

    /**
     * @param array $refundedTransactions
     *
     * @return RefundOverview
     */
    public function setRefundedTransactions(array $refundedTransactions): self
    {
        // TODO: transaction collection?
        $this->refundedTransactions = [];
        foreach ($refundedTransactions as $refundedTransaction) {
            $this->addRefundTransaction($refundedTransaction);
        }
        return $this;
    }

    /**
     * @param RefundTransaction $refundTransaction
     *
     * @return RefundOverview
     */
    public function addRefundTransaction(RefundTransaction $refundTransaction): self
    {
        $this->refundedTransactions[] = $refundTransaction;
        return $this;
    }

    /**
     * @return array
     */
    public function getFailedTransactions(): array
    {
        return $this->failedTransactions;
    }

    /**
     * @param array $failedTransactions
     *
     * @return RefundOverview
     */
    public function setFailedTransactions(array $failedTransactions): self
    {
        // TODO: transaction collection?
        $this->failedTransactions = [];
        foreach ($failedTransactions as $failedTransaction) {
            $this->addFailedTransaction($failedTransaction);
        }
        return $this;
    }

    /**
     * @param RefundTransaction $refundTransaction
     *
     * @return RefundOverview
     */
    public function addFailedTransaction(RefundTransaction $refundTransaction): self
    {
        $this->failedTransactions[] = $refundTransaction;
        return $this;
    }
}
