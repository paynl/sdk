<?php

namespace Paynl\Result\Payment;

use Paynl\Result\Result;

class EncryptionKeys extends Result
{
    /**
     * @return array
     */
    public function getKeys()
    {
        return isset($this->data['keys']) ? $this->data['keys'] : array();
    }
}