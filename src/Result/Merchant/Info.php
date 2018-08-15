<?php

namespace Paynl\Result\Merchant;

use Paynl\Result\Result;

class Info extends Result
{
    public function getTradeNames()
    {
        return $this->data['merchant']['tradeNames'];
    }
}
