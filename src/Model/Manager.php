<?php

declare(strict_types=1);

namespace PayNL\Sdk\Model;

use PayNL\Sdk\Service\AbstractPluginManager;

/**
 * Class Manager
 *
 * @package PayNL\Sdk\Model
 */
class Manager extends AbstractPluginManager
{
    /**
     * @var string
     *
     * @see AbstractPluginManager::$instanceOf
     */
    protected $instanceOf = ModelInterface::class;
}
