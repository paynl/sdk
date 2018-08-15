<?php

namespace Paynl\Result\DirectDebit;

use Paynl\Result\Result;

class Add extends Result
{
    public function getMandateId()
    {
        return $this->data['result'];
    }
}
