<?php

declare(strict_types=1);

namespace PayNL\Sdk\Config;

/**
 * Class ProviderInterface
 *
 * @package PayNL\Sdk\Config
 */
interface ProviderInterface
{
    public function __invoke(): array;

    public function getDependencyConfig(): array;
}
