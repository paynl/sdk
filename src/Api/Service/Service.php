<?php

namespace Paynl\Api\Service;

use Paynl\Api\Api;

class Service extends Api
{
    protected $apiTokenRequired = true;

    /**
     * @inheritdoc
     */
    protected $version = 3;
}
