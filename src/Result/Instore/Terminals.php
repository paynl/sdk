<?php

namespace Paynl\Result\Instore;

use Paynl\Result\Result;

/**
 * Result class for getTerminals
 *
 * @author Andy Pieters <andy@pay.nl>
 */
class Terminals extends Result
{
    public function getList()
    {
        return $this->data['terminals'];
    }
}
