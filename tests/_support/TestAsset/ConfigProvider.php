<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\{Config\Config,
    Config\ProviderInterface,
    Exception\ServiceNotCreatedException,
    Service\AbstractPluginManager,
    Service\Config as ServiceConfig};
use Psr\Container\ContainerInterface;

/**
 * Class SimpleConfigProvider
 *
 * @package Codeception\TestAsset
 */
class ConfigProvider implements ProviderInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        return [
            'service_manager' => $this->getDependencyConfig(),
            'service_loader_options' => [
                'simpleManager' => [
                    'service_manager' => 'simpleManager',
                    'config_key'      => 'simples',
                    'class_method'    => 'getSimpleConfig',
                ],
                'dummyManager' => [
                    'service_manager' => 'dummyManager',
                    'config_key' => 'dummies',
                    'class_method' => 'getDummyConfig',
                ],
            ],
            'models' => [
                'aliases' => [
                    'ComplexModel'           => 'complexModel',
                    'FailingModel'           => 'failingModel',
                    'SecondFailingModel'     => 'secondFailingModel',
                    'SimpleModel'            => 'simpleModel',
                    'SimpleCollection'       => 'simpleCollection',
                    'SimpleDateTime'         => 'simpleDateTime',
                    'SimpleDependencyObject' => 'simpleDependencyObject',
                ],
                'invokables' => [
                    'complexModel'           => ComplexModel::class,
                    'failingModel'           => FailingModel::class,
                    'secondFailingModel'     => SecondFailingModel::class,
                    'simpleModel'            => SimpleModel::class,
                    'simpleCollection'       => SimpleCollection::class,
                    'simpleDateTime'         => SimpleDateTime::class,
                    'simpleDependencyObject' => SimpleDependencyObject::class,
                ],
            ],
            'mappers' => [
                'aliases' => [
                    'SimpleDummyMapper' => SimpleDummyMapper::class,
                ],
                'factories' => [
                    SimpleDummyMapper::class => [$this, 'createMapper'],
                ],
                'mapping' => $this->getMap(),
            ],
            'hydrator_collection_map' => [
                'simpleModels' => 'simpleModel',
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getDependencyConfig(): array
    {
        return [
            'aliases' => [
                'simpleManager'  => SimplePluginManager::class,
                'dummyManager' => DummyPluginManager::class,
                'failingManager' => FailingPluginManager::class,
            ],
            'factories' => [
                DummyPluginManager::class => [$this, 'createManager'],
                FailingPluginManager::class => static function () {
                    return new FailingPluginManager();
                },
                SimplePluginManager::class => [$this, 'createManager'],
            ],
        ];
    }

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     *
     * @return AbstractPluginManager
     */
    public function createManager(ContainerInterface $container, string $requestedName, array $options = null): AbstractPluginManager
    {
        $configKeys = [
            SimplePluginManager::class => 'simples',
            DummyPluginManager::class  => 'dummies',
        ];

        $configKey = $configKeys[$requestedName] ?? null;

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

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     *
     * @return SimpleDummyMapper
     */
    public function createMapper(ContainerInterface $container, string $requestedName, array $options = null): SimpleDummyMapper
    {
        $mapConfig = $container->get('mapperManager')->getMapping()[$requestedName] ?? [];
        return new SimpleDummyMapper($mapConfig);
    }

    /**
     * @return array
     */
    public function getSimpleConfig(): array
    {
        return [
            'aliases' => [
                'foo'             => InvokableObject::class,
                'invokableObject' => InvokableObject::class,
                'InvokableObject' => InvokableObject::class,
            ],
            'invokables' => [
                'Invokable' => InvokableObject::class,
            ],
            'factories' => [
                InvokableObject::class => SampleFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getDummyConfig(): array
    {
        return [
            'aliases' => [
                'dummy' => 'Dummy',
            ],
            'invokables' => [
                'Dummy' => Dummy::class,
            ],
        ];
    }

    /**
     * @return ServiceConfig
     */
    public function getServiceConfig(): ServiceConfig
    {
        return new ServiceConfig();
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return new Config();
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return 'test';
    }

    /**
     * @return array
     */
    public function getMap(): array
    {
        return [
            'SimpleDummyMapper' => [
                'InvokableObject' => 'Dummy',
            ],
        ];
    }
}
