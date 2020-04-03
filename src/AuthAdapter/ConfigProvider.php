<?php

declare(strict_types=1);

namespace PayNL\Sdk\AuthAdapter;

use PayNL\Sdk\{
    Config\ProviderInterface as ConfigProviderInterface,
    Common\ManagerFactory
};

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\AuthAdapter
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(): array
    {
        return [
            'service_manager'        => $this->getDependencyConfig(),
            'service_loader_options' => [
                Manager::class => [
                    'service_manager' => 'authAdapterManager',
                    'config_key'      => 'authAdapters',
                    'class_method'    => 'getAuthAdapterConfig',
                ],
            ],
            'authentication'         => [
                'type'     => 'Basic',
                'username' => '',
                'password' => '',
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
                'authAdapterManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    /**
     * Declaration of the available adapters
     *
     * Method is used by the service loader to retrieve the configuration for the
     *  corresponding service manager
     *
     * @return array
     */
    public function getAuthAdapterConfig(): array
    {
        return [
            'aliases' => [
                'Basic' => 'basic',
            ],
            'invokables' => [
                'basic' => Basic::class,
            ],
        ];
    }
}
