<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;

/**
 * Class FailingConfigProvider1
 *
 * @package Codeception\TestAsset
 */
class FailingConfigProvider1 implements ConfigProviderInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getDependencyConfig(): array
    {
        return [];
    }
}
