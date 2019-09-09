<?php
declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

use PayNL\Sdk\Request\AbstractRequest;

/**
 * Class Transactions
 *
 * @package PayNL\Sdk\Request
 */
class GetAll extends AbstractRequest
{
    /**
     * @inheritDoc
     */
    public function getUri(): string
    {
        return 'transactions';
    }

    public function getMethod(): string
    {
        return 'GET';
    }
}
