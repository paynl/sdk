<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Request\RequestInterface;
use PayNL\Sdk\Service\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Model
 */
class Manager extends AbstractPluginManager
{
    protected $instanceOf = ModelInterface::class;

}
