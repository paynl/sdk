<?php

declare(strict_types=1);

namespace PayNL\Sdk\Api;

use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Api
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
            'api' => [
                'url'     => '',
                'version' => 1,
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
                'Api'       => Api::class,
                'api'       => Api::class,
                'ApiService' => Service::class,
                'apiService' => Service::class,
            ],
            'factories' => [
                Api::class     => Factory::class,
                Service::class => Factory::class,
            ],
        ];
    }
}
