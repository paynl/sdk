<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use Psr\Container\ContainerInterface;
use PayNL\Sdk\{
    Service\AbstractPluginManager,
    Service\Config as ServiceConfig,
    Exception\ServiceNotCreatedException,
    Hydrator\Manager as HydratorManager,
    Request\Manager as RequestManager,
    Model\Manager as ModelManager,
    AuthAdapter\Manager as AuthAdapterManager,
    Transformer\Manager as TransformerManager,
    Mapper\Manager as MapperManager,
    Validator\Manager as ValidatorManager,
    Filter\Manager as FilterManager
};

/**
 * Class ManagerFactory
 *
 * @package PayNL\Sdk\Common
 */
class ManagerFactory implements FactoryInterface
{
    /*
     * Constant definition of config keys corresponding to their manager
     */
    protected const CONFIG_KEYS = [
        HydratorManager::class    => 'hydrators',
        TransformerManager::class => 'transformers',
        AuthAdapterManager::class => 'authAdapters',
        RequestManager::class     => 'requests',
        ModelManager::class       => 'models',
        MapperManager::class      => 'mappers',
        ValidatorManager::class   => 'validators',
        FilterManager::class      => 'filters',
    ];

    /**
     * @inheritDoc
     *
     * @return AbstractPluginManager
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null): AbstractPluginManager
    {
        $configKey = self::CONFIG_KEYS[$requestedName] ?? null;
        if (null === $configKey) {
            throw new ServiceNotCreatedException(
                sprintf(
                    'Manager "%s" is not supported',
                    $requestedName
                )
            );
        }

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
        if (false === array_key_exists($configKey, $config) || false === is_array($config[$configKey])) {
            return $manager;
        }

        (new ServiceConfig($config[$configKey]))->configureServiceManager($manager);

        return $manager;
    }
}
