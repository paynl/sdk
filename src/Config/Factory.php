<?php

declare(strict_types=1);

namespace PayNL\Sdk\Config;

use PayNL\Sdk\Config\Loader as ConfigLoader;
use Psr\Container\ContainerInterface;
use PayNL\Sdk\Common\FactoryInterface;

/**
 * Class ConfigFactory
 *
 * @package PayNL\Sdk\Factory
 */
class Factory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        /** @var ConfigLoader $configLoader */
        $configLoader = $container->get('configLoader');

        return $configLoader->getMergedConfig();
    }
}
