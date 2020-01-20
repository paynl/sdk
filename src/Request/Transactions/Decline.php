<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request\Transactions;

/**
 * Class Approve
 *
 * @package PayNL\Sdk\Request\Transactions
 */
class Decline extends AbstractStatusChange
{
    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();
        $this->setStatus(static::STATUS_DECLINE);
    }
}
