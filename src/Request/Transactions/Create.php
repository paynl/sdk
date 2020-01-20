<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Create
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Create extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD_POST;
    }

    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'transactions';
    }
}
