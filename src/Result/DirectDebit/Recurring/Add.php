<?php

namespace Paynl\Result\DirectDebit\Recurring;

use Paynl\Result\Result;

class Add extends Result
{
    public function getMandateId()
    {
        return $this->data['result'];
    }
}
