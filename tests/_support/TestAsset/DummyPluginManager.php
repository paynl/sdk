<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Service\AbstractPluginManager;

/**
 * Class DummyPluginManager
 *
 * @package Codeception\TestAsset
 */
class DummyPluginManager extends AbstractPluginManager
{
    protected $instanceOf = DummyInterface::class;
}
