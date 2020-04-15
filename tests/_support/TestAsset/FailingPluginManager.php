<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Service\Manager;

/**
 * Class FailingPluginManager
 *
 * @package Codeception\TestAsset
 */
class FailingPluginManager extends Manager
{
    protected $instanceOf = InvokableObject::class;

    /**
     * FailingPluginManager constructor.
     *
     * @param $container
     * @param array $config
     */
    public function __construct($container = null, array $config = [])
    {
        if (true === is_array($container)) {
            $config = $container;
            $container = null;
        }
        parent::__construct($config);
    }
}
