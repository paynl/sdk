<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Service\AbstractPluginManager;

/**
 * Class SimplePluginManager
 *
 * @package Codeception\TestAsset
 */
class SimplePluginManager extends AbstractPluginManager
{
    protected $instanceOf = InvokableObject::class;
}
