<?php

namespace Paynl\Result\DirectDebit\Mandate;

use Paynl\Result\Result;

class Add extends Result
{
    public function getMandateId()
    {
        return $this->data['result'];
    }
}
