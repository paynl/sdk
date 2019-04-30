<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Result class for a refund
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class AddRecurring extends Result
{
    /**
     * @return string The id of the newly created transaction
     */
    public function getTransactionId()
    {
        return $this->data['transactionId'];
    }
}
