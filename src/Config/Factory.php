<?php

declare(strict_types=1);

namespace PayNL\Sdk\Config;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\{
    Common\FactoryInterface,
    Config\Loader as ConfigLoader
};

/**
 * Class ConfigFactory
 *
 * @package PayNL\Sdk\Factory
 */
class Factory implements FactoryInterface
{
    /**
     * @inheritDoc
     *
     * @return Config
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): Config
    {
        /** @var ConfigLoader $configLoader */
        $configLoader = $container->get('configLoader');

        return $configLoader->getMergedConfig();
    }
}
