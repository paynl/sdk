<?php

namespace Paynl\Result\Instore;

use Paynl\Result\Result;

/**
 * Result class for instore payment
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Payment extends Result
{
    /**
     * @return string The transaction id
     */
    public function getTransactionId()
    {
        return $this->data['transaction']['transactionId'];
    }

    /**
     * @return mixed The terminal hash for this transaction, use this for Instore::Status
     */
    public function getHash()
    {
        return $this->data['transaction']['terminalHash'];
    }

    /**
     * @return string The url to the status page
     */
    public function getRedirectUrl()
    {
        return $this->data['transaction']['issuerUrl'];
    }
}
