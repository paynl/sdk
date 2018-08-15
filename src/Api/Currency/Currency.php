<?php

namespace Paynl\Api\Currency;

use Paynl\Error;
use Paynl\Api\Api;
use Paynl\Helper;

class Currency extends Api
{
    protected $apiTokenRequired = true;
    protected $version = 2;

    /**
     * @inheritdoc
     */
    protected function processResult($result)
    {
        $output = Helper::objectToArray($result);

        if (!is_array($output)) {
            throw new Error\Api($output);
        }

        return $output;
    }
}
