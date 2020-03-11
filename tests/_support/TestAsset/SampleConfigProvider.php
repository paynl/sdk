<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;

/**
 * Class SampleConfigProvider
 *
 * @package Codeception\TestAsset
 */
class SampleConfigProvider implements ConfigProviderInterface
{
    public function __invoke(): array
    {
        return [
            'foo' => 'bar',
        ];
    }

    public function getDependencyConfig(): array
    {
        return [];
    }
}
