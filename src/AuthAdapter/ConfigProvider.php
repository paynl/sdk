<?php

declare(strict_types=1);

namespace PayNL\Sdk\AuthAdapter;

use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;
use PayNL\Sdk\Common\ManagerFactory;

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
                'authAdapterManager' => [
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
