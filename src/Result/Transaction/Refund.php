<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Result class for a refund
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Refund extends Result
{
    /**
     * @return string The refundId
     */
    public function getRefundId()
    {
        return $this->data['refundId'];
    }
}
