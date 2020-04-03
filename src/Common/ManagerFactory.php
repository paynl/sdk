<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\{
    Service\AbstractPluginManager,
    Service\Config as ServiceConfig,
    Exception\ServiceNotCreatedException
};

/**
 * Class ManagerFactory
 *
 * @package PayNL\Sdk\Common
 */
class ManagerFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     *
     * @throws ServiceNotCreatedException
     *
     * @return AbstractPluginManager
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): AbstractPluginManager
    {
        if (true === $container->get('config')->get('service_loader_options')->has($requestedName)) {
            $options = array_merge($options ?? [], ['loader_options' => $container->get('config')->get('service_loader_options')->get($requestedName)]);
        }

        /** @var AbstractPluginManager $manager */
        $manager = new $requestedName($container, $options ?? []);

        if (false === ($manager instanceof AbstractPluginManager)) {
            throw new ServiceNotCreatedException(
                sprintf(
                    'Manager "%s" must extend %s',
                    $requestedName,
                    AbstractPluginManager::class
                )
            );
        }

        if (true === $container->has('serviceLoader')) {
            return $manager;
        }

        if (false === $container->has('config')) {
            return $manager;
        }

        $config = $container->get('config');

        $configKey = $manager->getConfigKey();
        if (false === array_key_exists($configKey, $config) || false === is_array($config[$configKey])) {
            return $manager;
        }

        (new ServiceConfig($config[$configKey]))->configureServiceManager($manager);

        return $manager;
    }
}
