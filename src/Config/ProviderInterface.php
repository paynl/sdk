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
    /**
     * Makes the config provider object callable
     *
     * @return array
     */
    public function __invoke(): array;

    /**
     * Integrate this method to declare the classes necessary
     *
     * @return array
     */
    public function getDependencyConfig(): array;
}
