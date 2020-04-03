<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use PayNL\Sdk\{
    Config\ProviderInterface as ConfigProviderInterface,
    Common\ManagerFactory
};

/**
 * Class ConfigProvider
 *
 * @package PayNL\Sdk\Filter
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
                    'service_manager' => 'filterManager',
                    'config_key'      => 'filters',
                    'class_method'    => 'getFilterConfig',
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
                'filterManager' => Manager::class,
            ],
            'factories' => [
                Manager::class => ManagerFactory::class,
            ],
        ];
    }

    /**
     * Declaration of the available classes for the filter manager, this method
     * is used by the service loader to get the configuration for its manager
     *
     * @return array
     */
    public function getFilterConfig(): array
    {
        return [
            'aliases' => [
                'country' => Country::class,
                'Country' => Country::class,
                'state'   => State::class,
                'State'   => State::class,
            ],
            'factories' => [
                Country::class => Factory::class,
                State::class   => Factory::class,
            ],
        ];
    }
}
