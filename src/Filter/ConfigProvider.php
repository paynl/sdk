<?php

declare(strict_types=1);

namespace PayNL\Sdk\Filter;

use PayNL\Sdk\Common\ManagerFactory;
use PayNL\Sdk\Config\ProviderInterface as ConfigProviderInterface;

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
                'filterManager' => [
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
     * @return array
     */
    public function getFilterConfig(): array
    {
        return [
            'aliases' => [
                'country'         => Country::class,
                'Country'         => Country::class,
                'state'           => State::class,
                'State'           => State::class,
            ],
            'factories' => [
                Country::class         => Factory::class,
                State::class           => Factory::class,
            ],
        ];
    }
}
