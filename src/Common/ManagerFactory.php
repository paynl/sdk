<?php

declare(strict_types=1);

namespace PayNL\Sdk\Common;

use PayNL\Sdk\Hydrator\Manager as HydratorManager;
use PayNL\Sdk\Request\Manager as RequestManager;
use PayNL\Sdk\Model\Manager as ModelManager;
use PayNL\Sdk\AuthAdapter\Manager as AuthAdapterManager;
use PayNL\Sdk\Transformer\Manager as TransformerManager;
use PayNL\Sdk\Mapper\Manager as MapperManager;
use Psr\Container\ContainerInterface;
use PayNL\Sdk\Service\Config as ServiceConfig;

class ManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, array $options = null)
    {
        switch ($requestedName) {
            case HydratorManager::class:
                $configKey = 'hydrators';
                break;
            case TransformerManager::class:
                $configKey = 'transformers';
                break;
            case AuthAdapterManager::class:
                $configKey = 'authAdapters';
                break;
            case RequestManager::class:
                $configKey = 'requests';
                break;
            case ModelManager::class:
                $configKey = 'models';
                break;
            case MapperManager::class:
                $configKey = 'mappers';
                break;
            default:
                throw new \Exception('Manager not supported');
        }

        $manager = new $requestedName($container, $options ?? []);

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
