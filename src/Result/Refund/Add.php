<?php

namespace Paynl\Result\Refund;

use Paynl\Result\Result;

/**
 * Description of Add
 *
 * @author Chris de Jong <chris@eventix.io>
 */
class Add extends Result
{
    /**
     * @return string The refundId
     */
    public function getRefundId()
    {
        return (isset($this->data['refundedTransactions']) && isset($this->data['refundedTransactions']['refundId'])) ? $this->data['refundedTransactions']['refundId'] : '';
    }
}
