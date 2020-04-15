<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Common\DebugAwareInitializer,
    Config\ProviderInterface as ConfigProviderInterface,
    Common\ManagerFactory
};

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Hydrator
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        return [
            'service_manager' => $this->getDependencyConfig(),
            'service_loader_options' => [
                Manager::class => [
                    'service_manager' => 'hydratorManager',
                    'config_key'      => 'hydrators',
                    'class_method'    => 'getHydratorConfig'
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
                'hydratorManager' => Manager::class,
            ],
            'factories' => [
                Manager::class =>  ManagerFactory::class,
            ],
        ];
    }

    /**
     * Declaration of the available classes. This method is used by the service loader
     *  to get the configuration for the corresponding manager
     *
     * @return array
     */
    public function getHydratorConfig(): array
    {
        return [
            'initializers' => [
                DebugAwareInitializer::class,
            ],
            'factories' => [
                Entity::class => Factory::class,
            ],
            'aliases' => [
                'entity' => Entity::class,
                'Entity' => Entity::class,
            ],
        ];
    }
}
