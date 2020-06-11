<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;
use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Common\CollectionInterface;

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
     * @var RefundedTransactions
     */
    protected $refundedTransactions;

    /**
     * @var RefundedTransactions
     */
    protected $failedTransactions;

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
     * @return RefundedTransactions
     */
    public function getRefundedTransactions(): RefundedTransactions
    {
        return $this->refundedTransactions ?? new RefundedTransactions();
    }

    /**
     * @param RefundedTransactions $refundedTransactions
     *
     * @return RefundOverview
     */
    public function setRefundedTransactions(RefundedTransactions $refundedTransactions): self
    {
        $this->refundedTransactions = $refundedTransactions;
        return $this;
    }

    /**
     * @param RefundTransaction $refundTransaction
     *
     * @return RefundOverview
     */
    public function addRefundTransaction(RefundTransaction $refundTransaction): self
    {
        $this->getRefundedTransactions()->addRefundTransaction($refundTransaction);
        return $this;
    }

    /**
     * @return RefundedTransactions
     */
    public function getFailedTransactions(): RefundedTransactions
    {
        return $this->failedTransactions ?? new RefundedTransactions();
    }

    /**
     * @param FailedTransactions $failedTransactions
     *
     * @return RefundOverview
     */
    public function setFailedTransactions(RefundedTransactions $failedTransactions): self
    {
        $this->failedTransactions = $failedTransactions;
        return $this;
    }

    /**
     * @param RefundTransaction $refundTransaction
     *
     * @return RefundOverview
     */
    public function addFailedTransaction(RefundTransaction $refundTransaction): self
    {
        $this->getFailedTransactions()->addRefundTransaction($refundTransaction);
        return $this;
    }
}
