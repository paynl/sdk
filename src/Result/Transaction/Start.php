<?php

namespace Paynl\Result\Transaction;

use Paynl\Result\Result;

/**
 * Description of Start
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Start extends Result
{
    /**
     * @return string The transactionId
     */
    public function getTransactionId()
    {
        return $this->data['transaction']['transactionId'];
    }

    /**
     * @return string The url where the customer can complete the payment
     */
    public function getRedirectUrl()
    {
        return $this->data['transaction']['paymentURL'];
    }

    /**
     * @return string The payment reference (for manual transfer)
     */
    public function getPaymentReference()
    {
        return $this->data['transaction']['paymentReference'];
    }
    
    /**
     * @return mixed The terminal hash for this transaction, use this for Instore::Status
     */
    public function getHash()
    {
        return $this->data['terminal']['hash'];
    }
}
