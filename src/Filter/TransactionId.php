<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

/**
 * Class TransactionId
 *
 * @package PayNL\Sdk\Filter
 */
class TransactionId extends AbstractScalar
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'transactionId';
    }
}
