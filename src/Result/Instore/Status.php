<?php

namespace Paynl\Result\Instore;

use Paynl\Result\Result;

/**
 * Result class for terminal status
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Status extends Result
{
    public function getTransactionState()
    {
        return $this->data['transaction']['state'];
    }
    public function getTerminalState()
    {
        return $this->data['terminal']['state'];
    }
    public function getProgressPercentage()
    {
        return $this->data['progress']['percentage'];
    }
}
