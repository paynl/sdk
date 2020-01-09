<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\Service\AbstractPluginManager;

class Manager extends AbstractPluginManager
{
    protected $instanceOf = AbstractHydrator::class;
}
