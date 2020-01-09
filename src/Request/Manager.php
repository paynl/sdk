<?php

declare(strict_types=1);

namespace PayNL\Sdk\Request;

use PayNL\Sdk\Service\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Transformer
 */
class Manager extends AbstractPluginManager
{
    protected $instanceOf = RequestInterface::class;
}
