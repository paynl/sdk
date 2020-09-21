<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use Doctrine\Common\Collections\ArrayCollection;
use PayNL\Sdk\Common\CollectionInterface;

/**
 * Class RefundedTransactions
 *
 * @package PayNL\Sdk\Model
 */
class RefundedTransactions extends ArrayCollection implements
    ModelInterface,
    CollectionInterface
{

    public function getRefundedTransactions(): array
    {
        return $this->toArray();
    }

    public function setRefundedTransactions(array $transactions): self
    {
        $this->clear();

        if (0 === count($transactions)) {
            return $this;
        }

        foreach ($transactions as $trx) {
            $this->addRefundTransaction($trx);
        }

        return $this;
    }

    public function addRefundTransaction(RefundTransaction $transaction): self
    {
        $this->add($transaction);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCollectionName(): string
    {
        return 'refundedTransactions';
    }
}
