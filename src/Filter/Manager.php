<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use PayNL\Sdk\Service\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Filter
 */
class Manager extends AbstractPluginManager
{
    protected $instanceOf = FilterInterface::class;
}
