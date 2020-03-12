<?php

declare(strict_types=1);

namespace Codeception\TestAsset;

use PayNL\Sdk\Config\ProviderInterface;
use Psr\Container\ContainerInterface;

/**
 * Class SimpleConfigProvider
 *
 * @package Codeception\TestAsset
 */
class SimpleConfigProvider implements ProviderInterface
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
                    'config_key'      => 'testAssets',
                    'class_method'    => 'getTestAssetConfig',
                ],
            ],
            'models' => [
                'invokables' => [
                    'complexModel' => ComplexModel::class,
                    'simpleModel'  => SimpleModel::class,
                    'simpleCollection' => SimpleCollection::class,
                    'simpleDateTime' => SimpleDateTime::class,
                    'simpleDependencyObject' => SimpleDependencyObject::class,
                ],
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
                'failingManager' => FailingPluginManager::class,
            ],
            'factories' => [
                FailingPluginManager::class => static function (ContainerInterface $container) {
                    return new FailingPluginManager();
                },
                SimplePluginManager::class => static function (ContainerInterface $container) {
                    $pluginConfig = [
                        'invokables' => [
                            'invokableObject' => InvokableObject::class
                        ]
                    ];
                    return new SimplePluginManager($container, $pluginConfig);
                },
            ],
        ];
    }

    /**
     * @return array
     */
    public function getTestAssetConfig(): array
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
}
